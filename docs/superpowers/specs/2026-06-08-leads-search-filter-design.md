# Leads Search & Filter Design

**Date:** 2026-06-08
**Project:** VanMalderStudio.CRM
**Status:** Approved

## Scope

Add local search + status filter to the Leads page. No backend changes. Extend what already exists.

## Files changed

| File | Change |
|------|--------|
| `leads.ts` | Add `searchQuery`, inject `Router`, extend `applyFilters()`, replace `clearFilter()` with `clearFilters()` |
| `leads.html` | Replace `.lead-filter-bar` with `.leads-filter-bar` containing search input, status select, clear button, result count |
| `leads.scss` | Add `.leads-filter-bar` styles |

## Logic

`applyFilters()` — two sequential filters on `this.leads`:
1. If `selectedStatusFilter` is set → keep only leads where `lead.status === selectedStatusFilter`
2. If `searchQuery.trim()` is non-empty → case-insensitive `includes` across `companyName, contactName, email, phone, city, source`

`clearFilters()` — resets `searchQuery = ''`, `selectedStatusFilter = null`, calls `this.router.navigate(['/leads'])` to clear URL.

Query-param behavior preserved: `ngOnInit` still subscribes to `queryParamMap` and sets `selectedStatusFilter` from `?status=X`.

## HTML filter bar

```
[ 🔍 Zoek...        ] [ Status ▼ ] [ Filters wissen ]   X leads
```

- Search input: `[(ngModel)]="searchQuery"` + `(ngModelChange)="applyFilters()"`
- Status select: `[(ngModel)]="selectedStatusFilter"` + `(ngModelChange)="applyFilters()"` — same options as create form
- Clear button: only shown when `searchQuery || selectedStatusFilter`, calls `clearFilters()`
- Result count: `{{ filteredLeads.length }} leads` always visible

## Constraints

- Three files only
- No backend changes
- Beginner-friendly code
- Must compile with `ng build`
