#!/usr/bin/env bash
#
# Van Malder Studio — production deploy
#
# Usage (on the server, as the deploy user):
#   ./deploy.sh
#
# Optional environment overrides:
#   APP_DIR=/var/www/vanmalderstudio
#   BRANCH=main
#   WEB_GROUP=www-data
#   RELOAD_CMD="sudo systemctl reload php8.3-fpm"
#   SKIP_NPM=1
#
# What this script deliberately does NOT do:
#   - it never touches .env
#   - it never runs git reset --hard, migrate:fresh, db:wipe
#   - it never chmod 777 / chown -R the whole project
#   - it never removes storage/ or user uploads
#

set -euo pipefail

APP_DIR="${APP_DIR:-/var/www/vanmalderstudio}"
BRANCH="${BRANCH:-main}"
WEB_GROUP="${WEB_GROUP:-www-data}"
RELOAD_CMD="${RELOAD_CMD:-}"
SKIP_NPM="${SKIP_NPM:-0}"

# ── Helpers ──────────────────────────────────────────────────────────────────

log() {
    printf '\n\033[1;34m→ %s\033[0m\n' "$*"
}

ok() {
    printf '\033[1;32m✓ %s\033[0m\n' "$*"
}

warn() {
    printf '\033[1;33m! %s\033[0m\n' "$*"
}

die() {
    printf '\n\033[1;31m✗ %s\033[0m\n' "$*" >&2
    exit 1
}

# ── Cleanup / failure handling ────────────────────────────────────────────────

MAINTENANCE_ON=0

finish() {
    local code=$?

    if [ "$MAINTENANCE_ON" -eq 1 ]; then
        warn "Bringing the application back up after an error…"
        php artisan up || true
    fi

    if [ "$code" -ne 0 ]; then
        printf '\n\033[1;31m✗ Deploy FAILED (exit %s).\033[0m\n' "$code" >&2
        printf '\033[1;31mThe site was not updated cleanly. Check the output above.\033[0m\n' >&2
    fi
}

trap finish EXIT

# ── 1. Pre-flight checks ─────────────────────────────────────────────────────

log "Pre-flight checks"

[ -d "$APP_DIR" ] \
    || die "APP_DIR '$APP_DIR' does not exist. Set APP_DIR=/path/to/project."

cd "$APP_DIR"

for f in artisan composer.json package.json .env; do
    [ -f "$f" ] \
        || die "Expected file '$f' not found in $APP_DIR — is this the Van Malder Studio project?"
done

grep -q '"name": "laravel/laravel"' composer.json \
    || die "composer.json does not look like this project."

for bin in git php composer npm; do
    command -v "$bin" >/dev/null 2>&1 \
        || die "'$bin' is not installed or not in PATH."
done

APP_ENV_VALUE="$(
    grep -E '^APP_ENV=' .env \
        | cut -d= -f2- \
        | tr -d '"' \
        | tr -d "'" \
        || true
)"

if [ "$APP_ENV_VALUE" != "production" ]; then
    die "APP_ENV in .env is '${APP_ENV_VALUE:-<empty>}', expected 'production'. Refusing to deploy."
fi

ok "Project directory, required files and APP_ENV=production verified"

# ── 2. Git state ─────────────────────────────────────────────────────────────

log "Git state"

CURRENT_BRANCH="$(git rev-parse --abbrev-ref HEAD)"
BEFORE_COMMIT="$(git rev-parse --short HEAD)"

echo "Branch : $CURRENT_BRANCH"
echo "Commit : $BEFORE_COMMIT (before deploy)"

if [ "$CURRENT_BRANCH" != "$BRANCH" ]; then
    die "Checked-out branch is '$CURRENT_BRANCH' but deploy branch is '$BRANCH'. Switch branches manually first."
fi

if [ -n "$(git status --porcelain --untracked-files=no)" ]; then
    git status --short --untracked-files=no

    die "There are uncommitted changes on the server. Commit, stash or discard them manually — this script will not overwrite them."
fi

ok "Working tree is clean"

# ── 3. Fetch + safe fast-forward ─────────────────────────────────────────────

log "Fetching origin/$BRANCH"

git fetch --prune origin "$BRANCH"

LOCAL_HEAD="$(git rev-parse HEAD)"
REMOTE_HEAD="$(git rev-parse "origin/$BRANCH")"

if [ "$LOCAL_HEAD" = "$REMOTE_HEAD" ]; then

    warn "Already up to date with origin/$BRANCH — continuing so dependencies and caches are still refreshed."

elif git merge-base --is-ancestor HEAD "origin/$BRANCH"; then

    log "Fast-forwarding to origin/$BRANCH"

    git merge --ff-only "origin/$BRANCH"

else

    die "Server branch has diverged from or is ahead of origin/$BRANCH. Resolve this manually before deploying."

fi

AFTER_COMMIT="$(git rev-parse --short HEAD)"

ok "Now at $AFTER_COMMIT"

if [ "$BEFORE_COMMIT" != "$AFTER_COMMIT" ]; then
    echo
    git --no-pager log --oneline "$BEFORE_COMMIT..$AFTER_COMMIT"
fi

# ── 4. Build while site remains online ───────────────────────────────────────

log "Composer dependencies (production)"

composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader \
    --no-progress

ok "Composer done"

if [ "$SKIP_NPM" = "1" ]; then

    warn "SKIP_NPM=1 — skipping frontend build"

else

    log "Frontend dependencies + Vite build"

    npm ci --no-audit --no-fund

    npm run build

    [ -f public/build/manifest.json ] \
        || die "public/build/manifest.json missing after build — Vite build did not succeed."

    ok "Vite build done"

fi

# ── 5. Maintenance mode + database + Laravel caches ──────────────────────────

log "Entering maintenance mode"

php artisan down --retry=15 --refresh=5 || true

MAINTENANCE_ON=1

log "Database migrations"

php artisan migrate --force --no-interaction

log "Clearing stale caches"

php artisan optimize:clear

log "Rebuilding production caches"

php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

if [ ! -e public/storage ]; then

    log "Creating storage symlink"

    php artisan storage:link

fi

# ── 6. Permissions ────────────────────────────────────────────────────────────

log "Permissions (storage/, bootstrap/cache/)"

if getent group "$WEB_GROUP" >/dev/null 2>&1; then

    chgrp -R "$WEB_GROUP" storage bootstrap/cache 2>/dev/null \
        || sudo chgrp -R "$WEB_GROUP" storage bootstrap/cache 2>/dev/null \
        || warn "Could not chgrp storage/ and bootstrap/cache to '$WEB_GROUP'. Skipping."

    chmod -R ug+rwX storage bootstrap/cache 2>/dev/null \
        || sudo chmod -R ug+rwX storage bootstrap/cache 2>/dev/null \
        || warn "Could not chmod storage/ and bootstrap/cache. Skipping."

    ok "Writable directories set to group '$WEB_GROUP' (ug+rwX)"

else

    warn "Group '$WEB_GROUP' not found — skipping permission step."

fi

# ── 7. Bring application back online ─────────────────────────────────────────

log "Leaving maintenance mode"

php artisan up

MAINTENANCE_ON=0

if [ -n "$RELOAD_CMD" ]; then

    log "Reloading services: $RELOAD_CMD"

    bash -c "$RELOAD_CMD"

fi

# ── 8. Post-deploy checks ────────────────────────────────────────────────────

log "Post-deploy checks"

php artisan about --only=environment

APP_URL_VALUE="$(
    grep -E '^APP_URL=' .env \
        | cut -d= -f2- \
        | tr -d '"' \
        | tr -d "'" \
        || true
)"

if command -v curl >/dev/null 2>&1 && [ -n "$APP_URL_VALUE" ]; then

    HTTP_CODE="$(
        curl \
            -s \
            -o /dev/null \
            -w '%{http_code}' \
            -L \
            "$APP_URL_VALUE/nl" \
            || echo "000"
    )"

    if [ "$HTTP_CODE" = "200" ]; then

        ok "$APP_URL_VALUE/nl responds with HTTP 200"

    else

        warn "$APP_URL_VALUE/nl responded with HTTP $HTTP_CODE — verify the site manually."

    fi

fi

# ── Done ─────────────────────────────────────────────────────────────────────

printf '\n\033[1;32m✅ Deploy complete: %s → %s on branch %s\033[0m\n' \
    "$BEFORE_COMMIT" \
    "$AFTER_COMMIT" \
    "$BRANCH"

printf '\nRollback: revert the problematic commit(s) on %s, push the revert, then run ./deploy.sh again.\n' \
    "$BRANCH"