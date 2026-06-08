# Tasks Search & Filter Design

**Date:** 2026-06-08
**Project:** VanMalderStudio.CRM
**Status:** Approved

## Scope

Add local search + status + priority filtering to the Tasks page. Mirror the Leads filter bar exactly. No backend changes.

## Files changed

| File | Change |
|------|--------|
| `tasks.ts` | Add `filteredTasks`, `searchQuery`, `selectedStatusFilter`, `selectedPriorityFilter`; add `applyFilters()`, `clearFilters()`, `hasActiveFilters`; update `loadTasks()` and `createTask()` to call `applyFilters()` |
| `tasks.html` | Add `.tasks-filter-bar` row; change `@for` loop from `tasks` to `filteredTasks` |
| `tasks.scss` | Append `.tasks-filter-bar` styles (copy of leads-filter-bar pattern) |

## Filter logic (applyFilters)

1. Start from `this.tasks` (full list)
2. If `selectedStatusFilter` set → keep `task.status === selectedStatusFilter`
3. If `selectedPriorityFilter` set → keep `task.priority === selectedPriorityFilter`
4. If `searchQuery.trim()` non-empty → case-insensitive `includes` on `title`, `description`, `leadCompanyName`
5. Assign result to `filteredTasks`

## Filter bar HTML structure

```
[ Zoek...  ]  [ Status ▼ ]  [ Prioriteit ▼ ]  [ Filters wissen ]   X taken
```

## Constraints

- Three files only, no backend changes
- Existing task creation + inline status update untouched
- Must compile with `ng build`
