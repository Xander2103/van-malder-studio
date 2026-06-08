# Lead Detail — Tasks Section Design

**Date:** 2026-06-08
**Project:** VanMalderStudio.CRM
**Status:** Approved

## Scope

Add a "Taken" section to the Lead Detail page so tasks can be created and viewed from within a lead. No new files, no backend changes.

## Files changed

| File | Change |
|------|--------|
| `lead-detail.ts` | Inject TaskService; add task state, loadLeadTasks, toggleTaskForm, createLeadTask, helper methods |
| `lead-detail.html` | Add `<section class="tasks">` after the activities section |
| `lead-detail.scss` | Extend existing selectors; add task-specific classes |

## Data flow

- `loadLeadTasks()` calls `TaskService.getTasks()` and filters client-side by `task.leadId === this.leadId`
- `createLeadTask()` calls `TaskService.createTask()` with `leadId` set to the current lead, then calls `loadLeadTasks()`
- Tasks are read-only in this view (no inline status edit — that lives on `/tasks`)

## Component state added

```
leadTasks: TaskItem[]
isLoadingTasks: boolean
showTaskForm: boolean
isSavingTask: boolean
newTask: CreateTaskItem  (leadId always set to current leadId on submit)
```

## HTML structure

Mirrors `.activities` section exactly:
- `.tasks__header` row: eyebrow, h2, toggle button
- Toggle form (`.task-form`) inside `@if (showTaskForm)`
- Empty-state paragraph if no tasks
- `.task-list` with `.task-item` cards showing: title, description, due date, priority pill, status label

## Constraints

- Only three files touched
- No backend changes
- Existing activity and status flows untouched
- No inline status update in this view (YAGNI — `/tasks` already has that)
