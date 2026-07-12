# Prompt: Enhance the Login & Sign Up Pages in the Service Marketplace Project (Laravel + Tailwind)

## Overview

Enhance the **existing** Login and Sign Up pages in the Laravel + MongoDB service marketplace project to match the two attached reference designs and apply the provided Royal Blue & Gold color palette (CSS variables below) site-wide. This is a visual/UX upgrade of the current auth pages, not a rebuild from scratch — keep existing Laravel Breeze routes, controllers, and validation logic intact; only the markup, styling, and layout should change.

**Reference screenshots:** `Sign_Up_Page.png`, `Login_Page.png`

---

## Color Palette (apply globally, not just to auth pages)

Add the following CSS custom properties to the project's main stylesheet (e.g., `resources/css/app.css`) and wire them into the Tailwind config as theme colors, so they're usable as Tailwind utility classes (e.g., `bg-primary`, `text-secondary`) rather than only raw CSS variables:

```css
--primary: #1e40af;        /* Deep Royal Blue — primary buttons, links */
--primary-light: #3b82f6;  /* Medium Blue — hover/lighter accents */
--primary-dark: #1e3a8a;   /* Dark Blue — headers, active states */
--secondary: #d97706;      /* Luxury Gold — secondary CTAs, highlights */
--accent: #4f46e5;         /* Premium Indigo — accent elements */

--primary-lightest: #f0f7ff;
--primary-darker: #172554;
--primary-darkest: #0f172a;

--secondary-lightest: #fffbeb;
--secondary-light: #fde68a;
--secondary-dark: #b45309;
--secondary-darker: #78350f;

--accent-dark: #3730a3;
--accent-light: #818cf8;

--background: #f8fafc;
```

**Gradients** (use for hero sections, primary buttons, and any "premium" surfaces):

```css
--gradient-primary: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
--gradient-secondary: linear-gradient(135deg, var(--secondary) 0%, var(--secondary-dark) 100%);
--gradient-accent: linear-gradient(135deg, var(--accent) 0%, var(--primary-dark) 100%);
--background-gradient: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
--hover-gradient: linear-gradient(135deg, var(--primary-dark) 0%, var(--accent-dark) 100%);
```

Also carry over from the provided CSS:
- Global transition rule (350ms, `cubic-bezier(0.4, 0, 0.2, 1)`) on `a, button, select, input, textarea, tr, .transition`
- Layered colored shadow utilities (`shadow-sm/md/lg/xl`) tinted with the primary blue instead of default grey shadows
- Button hover effect: `translateY(-1px)` + `brightness(1.05)` on hover, reset on active

> **Note:** The reference screenshots currently render in black/white (neutral), not yet using this blue/gold palette. Apply the palette consistently across both pages — primary buttons ("Create Account", "Sign In") should use `--primary` or `--gradient-primary` instead of plain black, and focus/hover states should follow the palette above rather than default browser/Tailwind blues.

---

## Current State — What to Check Before Starting

Before making changes, review the existing `resources/views/auth/register.blade.php` and `resources/views/auth/login.blade.php` files and note:
- Which fields/markup can be kept as-is vs. restructured to match the reference layout
- Whether the project already has a site header/footer partial that these pages should adopt, or whether auth pages currently render standalone
- Whether existing validation error markup (`@error` blocks) and `old()` value retention are already wired up correctly, so the enhancement doesn't break current form submission behavior

---

## Page 1: Sign Up / Create Account — Enhancements to Apply

**Route:** `/register` (existing — no change)
**Blade view:** `resources/views/auth/register.blade.php` (edit in place)

### Layout enhancements (from reference)
- Add/align site header: logo/brand name top-left, "Sign In" button top-right, thin bottom border separating header from page (reuse existing header partial if one exists; otherwise create one)
- Wrap the form in a centered white card (rounded corners, subtle border, generous padding), vertically centered with breathing room above and below
- Card heading: **"Create Account"** (bold, large)
- Add subheading under the heading: short tagline relevant to the service marketplace, e.g., *"Book trusted home service professionals in minutes."* (replace generic placeholder copy)

### Form field enhancements
Keep existing field names/validation — update presentation only:

1. **Full Name** — label style "FULL NAME" (uppercase, small, grey), placeholder "John Doe"
2. **Email Address** — label "EMAIL ADDRESS", placeholder "name@company.com"
3. **Password** — add a show/hide toggle (eye icon) on the right side of the field if not already present
   - Add helper text below: *"Must be at least 8 characters with a mix of letters and symbols."*
4. **Checkbox** (if not already present): *"I agree to the Terms of Service and Privacy Policy."* — both terms are underlined inline links; checkbox required before submission

### Primary action button enhancement
- Full-width "Create Account" button — restyle with `--gradient-primary` or `--primary` background, white text, rounded corners, hover lift effect (per shared CSS)

### Footer enhancement
- Add horizontal divider above the existing "Already have an account? Sign In" link if not already styled this way

### Page footer (site-wide, shared with Login page)
- Add if missing: brand name + "© 2026 [Brand]. All rights reserved." bottom-left, "Privacy Policy | Terms of Service | Cookie Settings" links bottom-right

---

## Page 2: Login / Welcome Back — Enhancements to Apply

**Route:** `/login` (existing — no change)
**Blade view:** `resources/views/auth/login.blade.php` (edit in place)

### Layout enhancements (from reference)
- Reuse the same header used on the enhanced Sign Up page, with "Sign In" shown as the active/current-page state (bold, underlined)
- Set page background to a very light tinted wash using `--background` or `--background-gradient`, consistent with the rest of the site
- Wrap the form in the same card style used on Sign Up
- Card heading: **"Welcome Back"**
- Subheading: *"Log in to manage your bookings."* (or similar, adjusted to marketplace context)

### Form field enhancements
1. **Email** — label "Email" (confirm casing decision below)
2. **Password** — label "Password", add "Forgot password?" link aligned to the right of the label row if not already present, linking to the existing password reset flow
3. **Checkbox** (if not already present): *"Remember me for 30 days"* — maps to Laravel's built-in "remember" functionality, already available on the login form

### Primary action button enhancement
- Full-width "Sign In" button — same primary gradient style as the enhanced Sign Up button for visual consistency

### Footer enhancement
- Ensure "Don't have an account? Sign Up" link is present and styled consistently, linking to `/register`

### Page footer
Reuse the same footer component from the enhanced Sign Up page.

---

## Shared Component Requirements

- Extract the card, header, and footer into shared Blade components/partials (e.g., `x-auth-card`, `x-site-header`, `x-site-footer`) so both pages reuse the same markup instead of duplicating it — refactor existing markup into these components rather than writing new pages from scratch
- Preserve all existing Laravel Breeze validation and error-display conventions (`@error` directives per field, `old()` value retention on failed submission) — do not alter validation rules or backend logic, this is a presentation-layer enhancement only
- Add a reusable Alpine.js password-visibility-toggle component so it can be reused anywhere a password field appears (password reset, change password in profile, etc.)
- Ensure both pages remain fully responsive after the enhancement — card should shrink to near-full width with side padding on mobile, matching the card-based approach used elsewhere in the project
- Apply the RTL/Arabic translation requirements from the language-switch prompt to both pages: all labels, placeholders, helper text, button text, and links must be wrapped in `__()` and have Arabic translations; layout must mirror correctly in RTL mode

---

## Decisions to Confirm

1. **Label casing inconsistency:** Sign Up screenshot uses uppercase labels ("FULL NAME"), Login screenshot uses sentence case ("Email"). Confirm which style to standardize on across both enhanced pages.
2. **Brand name/logo:** reference shows "REAHAN ALFRAH" — confirm the actual brand name and whether a logo image should replace the text wordmark in the enhanced header.
3. **Tagline copy:** reference taglines are generic placeholder copy — confirm final wording or approve the marketplace-specific suggestions above.
4. **Terms of Service / Privacy Policy / Cookie Settings pages:** confirm these already exist in the project or need to be created, since the enhanced auth pages link to them.
5. Confirm whether any existing custom styling/classes on the current login/register pages need to be preserved for reasons not visible in the reference screenshots (e.g., analytics tracking hooks, third-party widget containers) before they are restyled.

---

## Deliverables

- [ ] Updated Tailwind config + CSS with the full color palette wired in as reusable utility classes, applied site-wide
- [ ] Enhanced `resources/views/auth/register.blade.php` matching the Sign Up reference design, with existing backend logic untouched
- [ ] Enhanced `resources/views/auth/login.blade.php` matching the Login reference design, with existing backend logic untouched
- [ ] New shared Blade components: auth card wrapper, site header, site footer, password-visibility-toggle — refactored from existing markup where possible
- [ ] Confirmation that both pages still submit correctly and display validation errors as before (regression check)
- [ ] Fully responsive on mobile, tablet, and desktop
- [ ] Arabic/RTL translation support applied per the existing language-switch requirements
