# Dashboard Action Lists Design

**Date:** 2026-06-08
**Project:** VanMalderStudio.CRM
**Status:** Approved

## Scope

Replace the generic bottom split section of the Dashboard with two real action-list panels fed by LeadService and TaskService. No backend changes.

## Files changed

| File | Change |
|------|--------|
| `dashboard.ts` | Inject LeadService + TaskService; use forkJoin; compute dueTodayTasks + warmLeads |
| `dashboard.html` | Replace `.dashboard-section--split` with two panels |
| `dashboard.scss` | Add `.action-row` and sub-element styles |

## Data loading

`forkJoin` fires all three API calls in parallel:
- `DashboardService.getSummary()` — unchanged
- `TaskService.getTasks()` — wrapped with `catchError(() => of([]))` so a failure returns empty array
- `LeadService.getLeads()` — same pattern

On success, filter client-side:

**dueTodayTasks:**
- `task.status === 1 || task.status === 2` (Open / In Progress)
- `task.dueDate` exists AND `new Date(task.dueDate) <= endOfToday`
- Sort by dueDate ascending
- `.slice(0, 5)`

**warmLeads:**
- `lead.status === 4 || lead.status === 6 || lead.status === 7` (Interested / Proposal Requested / Proposal Sent)
- `.slice(0, 5)` (no sort — backend order preserved)

## HTML panels

Two `<article class="focus-panel">` side by side (existing class, existing layout):

**Vandaag opvolgen:**
- `@for (task of dueTodayTasks; …)` → `.action-row` with title, lead name, due date, priority badge
- Each row links to `/tasks`
- Empty state: "Geen vervallen taken voor vandaag."

**Warme leads:**
- `@for (lead of warmLeads; …)` → `.action-row` with company name, contact name, status pill
- Each row links to `/leads/{id}`
- Empty state: "Geen warme leads op dit moment."

## Constraints

- Three files only
- No backend changes
- Statistics cards untouched
- Beginner-friendly: no state management, no complex reactive patterns
- Must compile with `ng build`
