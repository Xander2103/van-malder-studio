# Lead Business Value Fields Design

**Date:** 2026-06-08
**Project:** VanMalderStudio.CRM
**Status:** Approved

## Scope

Add EstimatedValue, ProposalValue and WinProbability to leads (backend model + DTOs + migration + frontend interfaces + forms + display). All fields optional. No pipeline dashboard yet.

## Backend files

| File | Change |
|------|--------|
| `Models/Lead.cs` | `decimal? EstimatedValue`, `decimal? ProposalValue`, `int? WinProbability` |
| `DTOs/CreateLeadDto.cs` | Same three nullable fields |
| `DTOs/UpdateLeadDto.cs` | Same three nullable fields |
| `DTOs/LeadResponseDto.cs` | Same three nullable fields |
| `Controllers/LeadsController.cs` | Map in GetLeads projection, GetLead mapping, CreateLead, UpdateLead |
| Migration | `AddLeadBusinessValueFields` |

## Frontend files

| File | Change |
|------|--------|
| `lead.service.ts` | Add `estimatedValue?: number \| null` etc. to Lead, CreateLead, UpdateLead |
| `leads.ts` | Add three null fields to newLead init + post-submit reset |
| `leads.html` | Three number inputs in create form |
| `lead-detail.ts` | Include three fields in updateStatus() UpdateLead object |
| `lead-detail.html` | Show in Status card |

## Critical constraint

`updateStatus()` builds UpdateLead manually — must include the three new fields from `this.lead` to avoid overwriting stored values with null.

## Constraints

- No pipeline dashboard
- No new pages/routes
- No authentication
- WinProbability: `min="0" max="100"` on input
- Must compile: `dotnet build` + `ng build`
