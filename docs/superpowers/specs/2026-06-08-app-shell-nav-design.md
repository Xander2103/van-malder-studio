# App Shell Navigation Design

**Date:** 2026-06-08
**Project:** VanMalderStudio.CRM
**Status:** Approved

## Scope

Add a sticky top navbar to the Angular app root so navigation is visible on every page. Zero changes to existing page components.

## Files changed

| File | Change |
|------|--------|
| `app.ts` | Add `RouterLink`, `RouterLinkActive` to imports; remove unused `title` signal |
| `app.html` | Replace bare `<main>` with `<nav>` + `<main class="app-main">` |
| `app.scss` | Add nav and layout styles |

## HTML structure

```
<nav class="app-nav">
  <a class="app-nav__brand" routerLink="/">VanMalderStudio CRM</a>
  <ul class="app-nav__links">
    <li><a routerLink="/" [routerLinkActiveOptions]="{exact:true}" routerLinkActive="app-nav__link--active">Dashboard</a></li>
    <li><a routerLink="/leads" routerLinkActive="app-nav__link--active">Leads</a></li>
    <li><a routerLink="/tasks" routerLinkActive="app-nav__link--active">Taken</a></li>
  </ul>
</nav>
<main class="app-main">
  <router-outlet></router-outlet>
</main>
```

## Design tokens (match existing pages)

- Nav background: `#ffffff`
- Nav border-bottom: `1px solid #edf0f6`
- Nav shadow: `0 2px 12px rgba(22, 32, 51, 0.07)`
- Brand: `#162033`, font-weight 800
- Default link: `#63708a`
- Active link: `#5267ff`, font-weight 700
- Nav height: ~64px

## Mobile

At ≤ 640px: brand and links stack vertically, links wrap, no hamburger. Natural wrapping.

## Constraints

- No changes to dashboard, leads, lead-detail, tasks components
- No external libraries
- No authentication
- Must compile with `ng build`
