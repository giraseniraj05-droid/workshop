# Prompt: Footer Contact Update, Admin Credential Rotation, Sitewide Subtle Animation System
### v3 — adds explicit customer/user-side animation coverage (Sections 1 & 2 unchanged from v2, verified against actual codebase)

## ⚠️ Before anything else — two live secrets, not just the passwords below

- Your **Brevo API key** (`BREVO_API_KEY=xkeysib-...`) is in `.env` — confirmed correctly gitignored, never committed to git history.
- This prompt contains **two new account passwords** in Section 2.

**Do not commit this `.md` file to `prompt/` with those passwords still in it.** Redact Section 2 first, or don't commit this file.

---

## 1. Footer Contact Info — Update Email & Phone

### New values
- **Email:** `ilyaskhokarrajas2019@gmail.com`
- **Phone:** `+971554414740`

Both the public footer (`resources/views/partials/site-footer.blade.php`) and the admin panel footer (`resources/views/layouts/admin.blade.php`) already pull from the same two translation keys — one edit updates every footer site-wide:

Edit `lang/en/messages.php` and `lang/ar/messages.php`:
```php
'footer_contact_phone' => '+971 55 441 4740',
'footer_contact_email' => 'ilyaskhokarrajas2019@gmail.com',
```

Verify:
```bash
grep -rn "footer_contact_phone\|footer_contact_email" lang/
```

---

## 2. Rotate Super Admin & Admin Passwords

### New values
- **Super Admin password:** `[REDACTED]`
- **Admin password:** `[REDACTED]`

`app/Models/User.php` uses Laravel's `'password' => 'hashed'` cast, but a mass `Builder::update()` bypasses casts entirely (raw query, no model instantiation) — so calling `Hash::make()` explicitly in the mass update below is correct with no double-hashing risk.

**Do NOT run `php artisan db:seed`** — `DatabaseSeeder.php` truncates every collection first (`User::truncate()`, `Booking::truncate()`, etc.). Use this instead, via `php artisan tinker`:

```php
use App\Models\User;
use Illuminate\Support\Facades\Hash;

User::where('role', 'Super Admin')->update([
    'password' => Hash::make('[REDACTED]'),
]);

User::where('role', 'Admin')->update([
    'password' => Hash::make('[REDACTED]'),
]);
```

This applies to every existing seeded Super Admin/Admin account (matching how `UserSeeder.php` currently creates several generic accounts per role) — if you want one specific named account instead, swap `where('role', ...)` for `where('email', '...')`. Log in as both roles afterward to confirm.

---

## 3. Sitewide Subtle Animation System — Admin Side AND Customer/User Side

### Confirmed starting point
`resources/css/app.css` and `tailwind.config.js` have zero `@keyframes`, no `prefers-reduced-motion`, nothing animated beyond this existing global rule:
```css
a, button, select, input, textarea, tr, .transition {
    transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 350ms !important;
}
```
Build on this everywhere, don't duplicate or fight it.

### The four required elements — applied deliberately, every time
1. **Trigger** — hover, click/tap, page load, scroll-into-view, focus, form submission/state change
2. **Motion** — `transform`, `opacity`, `border-color`, `background-position`, `box-shadow` only — never `width`/`height`/`margin`/`top`/`left`
3. **Easing** — a defined curve; `linear` only for continuous ambient loops, never for one-shot transitions
4. **Duration** — 150–250ms for micro-interactions, 300–500ms for entrances, multi-second for ambient effects

### Public marketing / guest pages (home, service listing, login, register)

| Component | Trigger | Motion | Easing | Duration |
|---|---|---|---|---|
| Service cards (`welcome.blade.php`) | Hover | Keep existing `group-hover:scale-105` + shadow/border shift; add the running-border effect (below) | `ease-in-out` | 250–300ms |
| Primary CTA buttons | Hover + Active | `translateY(-1px)` hover, `translateY(0) scale(0.98)` active | `cubic-bezier(0.4, 0, 0.2, 1)` | 150–200ms |
| Public + admin mobile hamburger menus | Click/tap | Slide + backdrop fade — **already implemented via Alpine `x-transition`, leave untouched** | `ease-linear` backdrop / `ease-out` panel | 150–200ms (already set) |

### Customer/user side (authenticated) — this is the part to make sure gets covered, grounded in your actual dashboard/booking/profile markup

This area was under-specified in the previous draft — it's not just the public homepage cards. Confirmed from `dashboard.blade.php`, `services/show.blade.php`, and `resources/views/profile/`:

| Component | Trigger | Motion | Easing | Duration |
|---|---|---|---|---|
| **Dashboard welcome banner** (`dashboard.blade.php` — the gradient "welcome back" hero block) | Page load | Fade + `translateY(10px → 0)` entrance on first paint | `ease-out` | 400ms |
| **Success/flash message banner** (`session('success')` block, appears on dashboard and after booking/enquiry submission) | Page load (when present) | Slide-down + fade in; auto-fade-out if you add a dismiss timer | `ease-out` in / `ease-in` out | 300ms in, 250ms out |
| **Booking history cards** (`dashboard.blade.php` — each `@forelse($bookings as $booking)` card, already has `hover:shadow-md transition`) | Hover | Extend existing hover to include a subtle `translateY(-2px)` lift alongside the shadow | `ease-out` | 200ms |
| **Status badges** (pending/accepted/completed/rejected/cancelled pills inside each booking card) | On status change (if updated live) or page load | Small `scale(0.9 → 1)` + fade pop-in — makes a status update feel acknowledged rather than just appearing | `ease-out` | 200ms |
| **Worker cards** (`services/show.blade.php` line ~99, `hover:border-teal-200 transition` already present) | Hover | Border-color shift (existing) + add subtle `translateY(-2px)` and shadow grow, matching the booking-card treatment above for consistency across the app | `ease-out` | 200ms |
| **Review/feedback cards** (`services/show.blade.php` line ~180, same card pattern as worker cards) | Scroll-into-view | Fade + `translateY(8px → 0)`, staggered ~60ms per card as the review list enters view | `ease-out` | 350ms |
| **Star rating input** (feedback submission — `FeedbackController`/feedback views) | Hover (preview) + click (commit) | Scale + color-fill transition per star | `ease-out` | 150ms — must feel immediate, this is direct manipulation feedback |
| **Booking form & enquiry form** (`services/show.blade.php`, the two `<form>` blocks) | Focus (inputs) + Submit (button) | Input focus: border/box-shadow ring grow-in (existing global rule already covers this). Submit button: brief `scale(0.98)` press-down on click before the page navigates away | Existing global `cubic-bezier(0.4, 0, 0.2, 1)` | 200ms |
| **Profile forms** (`profile/partials/update-profile-information-form.blade.php`, `update-password-form.blade.php`, `delete-user-form.blade.php`) | Submit → success state | The "Saved." confirmation text Breeze already shows via `x-data`/`x-transition` on save — verify it already animates in/out smoothly; if not, apply the same fade pattern as the flash message above rather than inventing a new one | `ease-out` | 200ms |
| **"Book New Service" CTA** (dashboard banner button) | Hover | Same button treatment as public CTAs — keep consistent, don't create a separate button animation style just because it's on an authenticated page | `cubic-bezier(0.4, 0, 0.2, 1)` | 150–200ms |

**The point of this section:** the customer-facing authenticated experience (dashboard, booking history, worker browsing, leaving reviews, managing their profile) should feel like the *same* polished product as the public marketing pages — not a plainer, unfinished-feeling "logged in" area. Reuse the same easing curves and duration bands established on the public side throughout this table rather than inventing new ones per page, so the whole site feels like one consistent motion language, not several different ones stitched together.

### Admin/Super Admin side

| Component | Trigger | Motion | Easing | Duration |
|---|---|---|---|---|
| Admin sidebar nav links | Hover | Background fade + animate *into* the `border-l-4` active state | `ease-out` | 200ms |
| Dashboard/admin stat cards | Scroll-into-view | Fade + `translateY(8px → 0)` | `ease-out` | 400–500ms, ~60–80ms stagger |
| Admin data tables (bookings/workers/services/admins — already `overflow-x-auto`) | — | Don't animate per-row on every re-render; cap any entrance effect to first page-load, first ~10-15 rows | `ease-out` | 300ms |

### The "running border" effect (service cards)

Verified against your real CSS variables:
```css
--primary: #1e40af;    /* Deep Royal Blue */
--secondary: #d97706;  /* Luxury Gold */
--accent: #4f46e5;     /* Premium Indigo */
```
```css
@keyframes border-flow {
    0% { background-position: 0% 50%; }
    100% { background-position: 200% 50%; }
}

.card-animated-border {
    position: relative;
    border-radius: inherit;
}

.card-animated-border::before {
    content: '';
    position: absolute;
    inset: 0;
    border-radius: inherit;
    padding: 1.5px;
    background: linear-gradient(90deg, var(--primary), var(--accent), var(--secondary), var(--primary));
    background-size: 200% 100%;
    -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
    -webkit-mask-composite: xor;
    mask-composite: exclude;
    opacity: 0;
    transition: opacity 300ms ease-out;
    animation: border-flow 6s linear infinite;
}

.card-animated-border:hover::before {
    opacity: 1;
}
```
Apply `card-animated-border` to service cards on `welcome.blade.php`, **and also** to the worker cards and review cards on `services/show.blade.php` for the same subtle premium feel on the customer-facing detail page, not just the homepage grid — this was a gap in the previous draft, which only scoped it to the homepage.

Linear easing is deliberately correct here (continuous ambient loop, avoids a restart snap) — this is the one intentional exception to "avoid linear for one-shot transitions."

### Hard constraints — apply across all three areas above (public, customer, admin)

1. **Add `prefers-reduced-motion` globally**, once:
   ```css
   @media (prefers-reduced-motion: reduce) {
       *, *::before, *::after {
           animation-duration: 0.01ms !important;
           animation-iteration-count: 1 !important;
           transition-duration: 0.01ms !important;
           scroll-behavior: auto !important;
       }
   }
   ```
2. **Never animate layout-reflow properties** (`width`, `height`, `top`, `left`, `margin`, `padding`).
3. **Don't touch existing Alpine `x-transition` timings** on either mobile menu (public header, admin sidebar).
4. **Test every directional (`translateX`) animation in RTL/Arabic** — the customer dashboard and booking forms are used in Arabic too, not just the public marketing pages; don't limit RTL testing to the homepage.
5. **Presentation-only** — no controller/model/route/validation logic changes in this pass, on any of the three areas.
6. **Admin tables** — don't animate every row on every re-render.
7. **Consistency check specifically for this revision:** before marking this done, do one pass comparing the public homepage's motion feel against the customer dashboard's motion feel side-by-side — they should feel like the same designer built both, not two different eras of the app.

### Deliverables checklist
- [ ] `footer_contact_phone` / `footer_contact_email` updated in both lang files
- [ ] Super Admin and Admin passwords rotated via `tinker` mass-update, not a reseed
- [ ] Logged in as both roles to confirm new passwords work
- [ ] This prompt file redacted or excluded from git if Section 2 is left in it
- [ ] Public-side animations applied (cards, buttons, mobile menus)
- [ ] **Customer/user-side animations applied**: dashboard banner entrance, flash message in/out, booking card hover lift, status badge pop-in, worker card hover, review card scroll-in with stagger, star rating hover/click, booking + enquiry form focus/submit feedback, profile form save confirmation
- [ ] Admin-side animations applied (sidebar nav, stat cards, table entrance capped to first load)
- [ ] Running-border effect applied to service cards on homepage **and** worker/review cards on the service detail page
- [ ] `prefers-reduced-motion` rule added globally
- [ ] No layout-reflow properties animated anywhere
- [ ] RTL pass done on customer-side pages specifically (dashboard, booking form), not just the homepage
- [ ] Side-by-side consistency check: public pages and customer dashboard feel like one cohesive motion language
- [ ] Full regression click-through — nothing functions differently, only feels more polished
