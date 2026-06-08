# Tasks Page Design

**Date:** 2026-06-08
**Project:** VanMalderStudio.CRM (Angular + ASP.NET Core)
**Status:** Approved

## Scope

Build the Angular Tasks page that talks to the existing backend Tasks API. No backend changes needed.

## API shape (existing backend)

- `GET /api/Tasks` — returns all tasks ordered by status, then due date
- `GET /api/Tasks/due` — overdue tasks (not done/cancelled)
- `POST /api/Tasks` — create a task
- `PUT /api/Tasks/{id}` — update a task (title, description, dueDate, priority, status, leadId)
- `DELETE /api/Tasks/{id}` — delete a task

Response fields: `id, title, description, dueDate, priority (1–4), status (1–5), leadId?, leadCompanyName?, createdAt, updatedAt`

## Enums

Priority: 1=Low, 2=Normal, 3=High, 4=Urgent
Status: 1=Open, 2=In progress, 3=Done, 4=Postponed, 5=Cancelled

## Files

### New

| File | Purpose |
|------|---------|
| `src/app/services/task.service.ts` | HTTP service with interfaces + methods |
| `src/app/pages/tasks/tasks.ts` | Standalone component class |
| `src/app/pages/tasks/tasks.html` | Template |
| `src/app/pages/tasks/tasks.scss` | Scoped styles matching existing design |
| `src/app/pages/tasks/tasks.spec.ts` | Minimal spec file |

### Modified

| File | Change |
|------|--------|
| `src/app/app.routes.ts` | Add `{ path: 'tasks', component: Tasks }` |
| `src/app/pages/dashboard/dashboard.html` | Update 3 action-item links from `/leads` to `/tasks` |

## Component design

**task.service.ts**
- `TaskItem` interface (API response shape)
- `CreateTaskItem` interface (title required, rest optional)
- `UpdateTaskItem` interface (all fields for PUT)
- `getTasks()`, `createTask()`, `updateTask()`, `deleteTask()`

**tasks.ts**
- `tasks: TaskItem[]` loaded on `ngOnInit`
- `showCreateForm` toggle
- `newTask: CreateTaskItem` model bound via ngModel
- `createTask()` — POST, prepend result to list, reset form
- `updateTaskStatus(task, newStatus)` — PUT with full task data, then reload list
- `getStatusLabel()` and `getPriorityLabel()` helpers

**tasks.html**
- Header with eyebrow, h1, back link, "Nieuwe taak" toggle button
- Toggle form (same pattern as leads.html)
- Table: Title | Description | Due date | Priority | Status | Lead
- Status column: inline `<select>` that calls `updateTaskStatus` on change
- Priority column: badge pill with color coding
- `@if`/`@for` Angular control flow

**tasks.scss**
- Matches leads.scss naming: `.tasks-page`, `.tasks-page__header`, `.tasks-table`, `.priority-pill`, etc.
- Same color variables: `#5267ff` primary, `#162033` dark, `#f5f7fb` bg

## Constraints

- Standalone components only (`imports: [FormsModule, RouterLink]`)
- No NgModules, no state management, no toast system
- Status update: `select change → PUT → reload full list` (simple, no optimistic UI)
- No task filtering yet
- No authentication
- Must compile with `ng build`
