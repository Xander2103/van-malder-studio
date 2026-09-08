// =============================================================================
// Cookie consent — Google Consent Mode v2
//
// The head snippet in layouts/app.blade.php already:
//   1. created dataLayer/gtag,
//   2. set consent default to DENIED for all four keys,
//   3. restored a saved choice from the "vms_consent" cookie (window.vmsConsent),
//   4. configured and loaded the Google tag.
// This module only owns the UI: show the banner when no choice exists, persist the
// visitor's decision, push the matching consent update, and allow reopening later.
// =============================================================================

const COOKIE_NAME = 'vms_consent';
const COOKIE_MAX_AGE = 60 * 60 * 24 * 180; // 6 months
const VERSION = 1;

function readCookie() {
    if (window.vmsConsent && typeof window.vmsConsent === 'object') return window.vmsConsent;
    const match = document.cookie.match(new RegExp('(?:^|; )' + COOKIE_NAME + '=([^;]*)'));
    if (!match) return null;
    try {
        const parsed = JSON.parse(decodeURIComponent(match[1]));
        if (!parsed || parsed.v !== VERSION) return null;
        return { analytics: !!parsed.analytics, ads: !!parsed.ads };
    } catch (e) {
        return null;
    }
}

function writeCookie(choice) {
    // Only the decision itself is stored — no identifiers, no personal data.
    const value = encodeURIComponent(JSON.stringify({ v: VERSION, analytics: !!choice.analytics, ads: !!choice.ads, t: Date.now() }));
    const secure = window.location.protocol === 'https:' ? '; Secure' : '';
    document.cookie = `${COOKIE_NAME}=${value}; Max-Age=${COOKIE_MAX_AGE}; Path=/; SameSite=Lax${secure}`;
    window.vmsConsent = { analytics: !!choice.analytics, ads: !!choice.ads };
}

function updateGtag(choice) {
    if (typeof window.gtag !== 'function') return;
    window.gtag('consent', 'update', {
        analytics_storage: choice.analytics ? 'granted' : 'denied',
        ad_storage: choice.ads ? 'granted' : 'denied',
        ad_user_data: choice.ads ? 'granted' : 'denied',
        ad_personalization: choice.ads ? 'granted' : 'denied',
    });
    // Lets other scripts (e.g. future conversion tracking) react to a change.
    document.dispatchEvent(new CustomEvent('vms:consent', { detail: { ...choice } }));
}

export function initConsent() {
    const banner = document.querySelector('[data-consent-banner]');
    if (!banner) return;

    const panels = {
        notice: banner.querySelector('[data-consent-panel="notice"]'),
        preferences: banner.querySelector('[data-consent-panel="preferences"]'),
    };
    const boxes = {
        analytics: banner.querySelector('[data-consent-category="analytics"]'),
        ads: banner.querySelector('[data-consent-category="ads"]'),
    };

    let reopened = false;

    function showPanel(name) {
        panels.notice.hidden = name !== 'notice';
        panels.preferences.hidden = name !== 'preferences';
    }

    function open(panel, focus) {
        const saved = readCookie();
        if (boxes.analytics) boxes.analytics.checked = !!(saved && saved.analytics);
        if (boxes.ads) boxes.ads.checked = !!(saved && saved.ads);
        showPanel(panel);
        banner.hidden = false;
        if (focus) {
            const first = banner.querySelector(panel === 'preferences' ? '[data-consent-category]' : '[data-consent-action="accept"]');
            if (first) first.focus();
        }
    }

    function close() {
        banner.hidden = true;
    }

    function decide(choice) {
        writeCookie(choice);
        updateGtag(choice);
        close();
    }

    banner.addEventListener('click', (event) => {
        const button = event.target.closest('[data-consent-action]');
        if (!button) return;
        switch (button.dataset.consentAction) {
            case 'accept':
                decide({ analytics: true, ads: true });
                break;
            case 'reject':
                decide({ analytics: false, ads: false });
                break;
            case 'save':
                decide({ analytics: !!(boxes.analytics && boxes.analytics.checked), ads: !!(boxes.ads && boxes.ads.checked) });
                break;
            case 'preferences':
                showPanel('preferences');
                if (boxes.analytics) boxes.analytics.focus();
                break;
            case 'back':
                showPanel('notice');
                break;
        }
    });

    // Escape only closes the banner when a decision already exists (reopened from the footer);
    // a first-time visitor must make an explicit choice.
    banner.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && reopened && readCookie()) close();
    });

    // "Cookie preferences" links in the footer / privacy page.
    document.querySelectorAll('[data-consent-open]').forEach((trigger) => {
        trigger.addEventListener('click', (event) => {
            event.preventDefault();
            reopened = true;
            open('preferences', true);
        });
    });

    // First visit: no saved decision → show the notice. Focus is not stolen from the page.
    if (!readCookie()) {
        open('notice', false);
    }
}

// =============================================================================
// GA4 conversion architecture
// One standard event for every successful lead form:
//     gtag('event', 'generate_lead', { lead_type: 'project_inquiry' | 'quick_message' })
// The element carrying data-track-event is only rendered by the server after a
// confirmed successful submission (session flash in pages/contact.blade.php), so
// button clicks and failed submissions never produce an event. It goes through
// gtag, so Consent Mode decides whether anything identifiable leaves the browser.
// =============================================================================
export function trackConfirmedEvents() {
    if (typeof window.gtag !== 'function') return;
    document.querySelectorAll('[data-track-event]').forEach((el) => {
        const name = el.dataset.trackEvent;
        if (!name) return;
        const params = {};
        if (el.dataset.trackLeadType) params.lead_type = el.dataset.trackLeadType;
        window.gtag('event', name, params);
    });
}

initConsent();
trackConfirmedEvents();
