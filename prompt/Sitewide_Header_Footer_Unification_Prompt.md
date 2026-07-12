# Prompt: Roll Out the Login Page's Header & Footer Site-Wide (Laravel + Tailwind)

## Overview

The Login and Register pages (`resources/views/auth/login.blade.php`, `resources/views/auth/register.blade.php`) already use a polished header/footer via `@include('partials.site-header')` and `@include('partials.site-footer')`. The rest of the app uses two other, inconsistent header/footer implementations. Unify everything on the Login page's design **without altering how Login/Register currently look or behave.**

This is a refactor + rollout task, not a redesign — the visual result on every page should match what's on `/login` today, just wired into different pages.

---

## Current State — What to Check Before Starting

Three separate header/footer systems exist right now. Confirm this inventory still matches before touching anything:

1. **Source of truth (do not visually change):** `partials/site-header.blade.php` + `partials/site-footer.blade.php`, used only by `auth/login.blade.php` and `auth/register.blade.php`. Styled by CSS class selectors (`.login-header` / `.register-header`, `.brand`, `.brand-mark`, `.header-actions`, `.lang-pill`, `.header-link`, `.is-active`, `.page-footer`, `.page-footer-inner`, `.page-footer-brand`, `.page-footer-copy`) that are **embedded in `<style>` blocks inside each of those two pages**, not in a shared stylesheet.
2. **To be replaced:** `components/site-header.blade.php` + `components/site-footer.blade.php` (Tailwind-utility version), currently used by `welcome.blade.php` (home) and `layouts/guest.blade.php` (used by `pages/legal.blade.php` and any Breeze pages still on that layout — forgot-password, reset-password, confirm-password, verify-email).
3. **To be replaced:** hand-rolled, independently duplicated `<header>` markup inside `services/show.blade.php`, `layouts/app.blade.php` (page-level, plus the `layouts/navigation.blade.php` include it pulls in), and `layouts/admin.blade.php`. No footer currently exists on the admin layout or the app/dashboard layout — confirm that during implementation.

---

## Step 1 — Extract Before You Reuse

Before wiring the login-style header/footer into any other page:

- Move the `.login-header`/`.register-header`, `.brand*`, `.header-actions`, `.lang-pill`, `.header-link`, `.is-active`, `.page-footer*` CSS out of the inline `<style>` blocks in `auth/login.blade.php` and `auth/register.blade.php` and into a shared stylesheet (e.g. a new `resources/css/site-chrome.css`, imported once via `resources/css/app.css`).
- Delete the now-duplicated rules from both auth pages' `<style>` blocks once the shared file is confirmed working, so there is exactly one source for this CSS.
- **Regression check right after extraction:** load `/login` and `/register` and confirm pixel-for-pixel the same appearance before proceeding — this is the checkpoint that guarantees the rest of the rollout can't visually regress those two pages.

---

## Step 2 — Generalize the Partials

`partials/site-header.blade.php` currently hardcodes a two-state `$page` check (`login` / `register`) to decide the active nav pill. Extend it (without changing its login/register output) to also handle:

- `home` — no nav item marked active, or a `Home` item added and marked active (confirm with stakeholder — see Decisions below)
- Authenticated states — when `Auth::check()` is true, replace the `Sign In` / `Register` pills with a `Dashboard` link (routed by role, matching `DashboardController@index`'s redirect logic) and a `Log Out` action, instead of showing sign-in/register links to a logged-in user
- Any other `$page` values used by the pages in Step 3, so each can mark itself active in the pill nav where relevant (e.g. `$page = 'services'` on the service detail page)

`partials/site-footer.blade.php` currently has no legal links, while `components/site-footer.blade.php` (the one being replaced) does — carry the `Privacy Policy | Terms of Service | Cookie Settings` links over into the unified footer so that functionality isn't lost.

---

## Step 3 — Swap Each Page Over

Replace the old header/footer include in each of the following with `@include('partials.site-header', ['page' => '...'])` / `@include('partials.site-footer')`, adjusting each page's `<style>`/layout wrapper only as needed to remove now-redundant CSS:

- `welcome.blade.php` (home) — replace `<x-site-header />` / `<x-site-footer />`
- `layouts/guest.blade.php` — replace `<x-site-header :page="$page" />` / `<x-site-footer />` (affects `pages/legal.blade.php` and any other view still using `x-guest-layout`)
- `services/show.blade.php` — replace the inline `<header class="bg-white border-b ...">` block
- `layouts/app.blade.php` (and/or `layouts/navigation.blade.php`, whichever owns the markup) — replace the inline header; add the footer, which doesn't currently exist on this layout
- `layouts/admin.blade.php` — replace the inline header; add the footer, which doesn't currently exist on this layout (confirm the admin sidebar/nav, which is separate from the top header, is unaffected)
- `worker/dashboard.blade.php` / worker layout, if it has its own separate header markup rather than inheriting one of the above

For pages behind auth (dashboard, admin, worker), the header's Sign In/Register pills must switch to the authenticated state built in Step 2.

---

## Decisions to Confirm

1. Should the unified header show a **Home** nav pill, and should it appear active on `/`? Login/Register today only ever show Sign In/Register as pills — home has no equivalent yet.
2. For **authenticated pages** (dashboard, admin, worker), what should the pill nav contain — just `Dashboard` + `Log Out`, or also a link back to the public home/services page?
3. Should the **admin layout's existing sidebar navigation** be left completely untouched, with only the top bar swapped for the unified header? (Assumption: yes — this prompt only targets the top header/footer, not sidebar nav.)
4. The old `components/site-header.blade.php` / `components/site-footer.blade.php` and the ad hoc headers in `services/show.blade.php`, `layouts/app.blade.php`, `layouts/admin.blade.php` — once nothing references them, should they be deleted or left in place unused?

---

## Deliverables

- [ ] Shared `site-chrome.css` (or equivalent) containing the login-page header/footer CSS, imported once, with the duplicate copies removed from `auth/login.blade.php` and `auth/register.blade.php`
- [ ] `/login` and `/register` visually unchanged after the CSS extraction (regression check)
- [ ] `partials/site-header.blade.php` extended to support `home`, authenticated, and other page states without changing its `login`/`register` output
- [ ] `partials/site-footer.blade.php` extended with the legal links, still matching the login page's visual style
- [ ] Home, services detail, customer dashboard, admin, and worker pages all rendering the same header/footer as `/login`
- [ ] RTL/Arabic layout confirmed correct on every page that was touched, matching how login/register already handle it
- [ ] Old unused header/footer components/markup removed or explicitly kept, per the decision above
