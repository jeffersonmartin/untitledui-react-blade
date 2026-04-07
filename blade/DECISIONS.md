# Migration Decisions & Assumptions

This document tracks architectural decisions, assumptions, and items needing review
for the React-to-Blade component migration.

## Architecture Decisions

### 1. Alpine.js over Livewire for interactivity
**Decision:** Use Alpine.js (not Livewire) for all client-side interactivity.
**Reason:** These are UI components needing instant client-side state (open/close, hover, focus).
Livewire would introduce server round-trips for every dropdown open, tooltip hover, etc.
Alpine.js maps 1:1 to React's useState patterns.

**Required Alpine plugins:**
- `@alpinejs/focus` — focus trapping for modals/slideouts
- `@alpinejs/anchor` — popover positioning for dropdowns/selects/tooltips
- `@alpinejs/collapse` — animated expand/collapse for nav items

### 2. Icon strategy: name strings instead of component references
**Decision:** Blade components accept icon names as strings (`icon="home-01"`),
rendered internally via `<x-untitledui::icon>` which loads SVGs from the package's icon directory.
**Reason:** React passes icons as component references (`iconLeading={ChevronDown}`).
Blade has no equivalent — it uses string-based component resolution.
**Action needed:** Extract SVGs from `@untitledui/icons` npm package into `resources/views/components/icons/`.
Consider using `blade-ui-kit/blade-icons` for the integration layer.

### 3. Class merging via PHP tailwind-merge
**Decision:** Use `gehrisandro/tailwind-merge-laravel` package for the `cx()` PHP helper.
**Reason:** Direct equivalent of the React `cx()` (tailwind-merge wrapper).
Ensures class conflict resolution works identically.

### 4. Component architecture: anonymous vs class-based
**Decision:**
- **Anonymous components** (.blade.php with `@props`): Avatar, Badge, Label, HintText,
  FeaturedIcon, Toggle, EmptyState, LoadingIndicator, ProgressBar, etc.
- **Class-based components** (PHP class + view): Button (complex variant logic),
  Select (Alpine.js data setup), Dropdown (Alpine.js data setup), Table (context sharing).
**Reason:** Class-based only when computing styles from many variants or when
sub-component coordination requires PHP-side logic.

### 5. Compound components via Blade dot notation
**Decision:** `<Select.Item>` becomes `<x-untitledui::select.item>`.
Parent-child data sharing via Laravel's `@aware` directive and Alpine.js `$data` scope.
**Reason:** Direct Blade equivalent of React's compound component pattern.

### 6. `sortCx` dropped entirely
**Decision:** The `sortCx()` utility is removed. Style maps become PHP `match()` expressions.
**Reason:** `sortCx` was a no-op function used only for Tailwind IntelliSense sorting in JS.
It has no runtime effect and no PHP equivalent is needed.

## Assumptions

### A1. Tailwind CSS v4.2 in the consuming Laravel project
**Assumption:** The Laravel app uses Tailwind CSS v4+ with `@theme {}` block support.
The `theme.css` is ported as-is using `@theme {}` syntax.
**If wrong:** Need to convert `@theme {}` blocks to `tailwind.config.js` extend format for v3.

### A2. Component namespace prefix
**Assumption:** Components use `<x-untitledui::component-name>` prefix.
Users can publish and customize. The service provider registers the `untitledui` namespace.
**Alternative:** Could be configured to use `<x-ui::*>` or bare `<x-*>` via publishing.

### A3. No server-side rendering of icons from @untitledui/icons
**Assumption:** Icon SVGs need to be extracted/exported separately from the npm package
and placed into the Blade package. This is a manual step not automated in this migration.
**Action needed:** Run extraction script or manually copy SVGs.

### A4. Charts require separate library
**Assumption:** Recharts (React-only) is replaced by Chart.js.
The Blade chart component is a thin wrapper passing JSON data to a `<canvas>` element.
Chart.js was chosen over ApexCharts for lighter bundle size.
**Review:** If the team prefers ApexCharts, the wrapper interface stays the same.

### A5. Date picker uses Flatpickr
**Assumption:** React Aria's DatePicker + @internationalized/date is replaced by Flatpickr
with Alpine.js integration, styled to match the design tokens.
**Review:** Consider Pikaday as alternative. The React version had custom calendar rendering
which Flatpickr doesn't replicate — but it covers 90% of use cases with less code.

### A6. Carousel uses Splide.js
**Assumption:** Embla Carousel (React-only) replaced by Splide.js.
**Review:** Swiper.js is another option. Splide chosen for smaller size and simpler API.

## Items Needing Review

### R1. `in-data-*` Tailwind variants
The React Button uses custom variants like `in-data-input-wrapper:` which rely on
`tailwindcss-react-aria-components` plugin. These are converted to standard CSS
selectors in the Blade version. Review if all edge cases are covered.

### R2. `data-icon` attribute pattern
React uses `data-icon` attributes for SSR icon styling (`*:data-icon:size-5`).
Blade version uses explicit class props on the icon component instead.
This changes how icon sizing works inside buttons — verify visual parity.

### R3. React Aria keyboard navigation completeness
Select, Dropdown, and ComboBox have complex keyboard navigation from React Aria
(arrow keys, type-ahead search, Home/End, etc.). The Alpine.js implementations
cover arrow keys + Escape + Enter but may miss edge cases like:
- Type-ahead character search in Select
- Page Up/Page Down in long lists
- Roving tabindex in radio groups

### R4. Animation timing parity
React uses `isEntering`/`isExiting` state from React Aria with `tailwindcss-animate`.
Alpine uses `x-transition` which has different timing defaults.
Review enter/leave duration and easing to match React version.

### R5. Form integration
React version has `hook-form.tsx` for React Hook Form integration.
Laravel equivalent is standard form submission or Livewire forms.
The hook-form integration is intentionally not ported.

### R6. Shared assets (illustrations, mockups, patterns)
Background patterns, illustrations, iPhone mockup, and credit card components
are SVG-heavy React components. They're converted to Blade includes but the
SVG content is large. Consider extracting to publishable asset files.

### R7. `tailwindcss-react-aria-components` plugin removal
This plugin adds data-attribute variants (`data-[selected]:`, `data-[focused]:`, etc.)
used by React Aria. After removal, any Tailwind classes using these variants
need to be converted to Alpine.js `:class` bindings or standard CSS.

### R8. QR Code component
Uses `qr-code-styling` npm package. Need a JS-compatible QR library.
Consider `qrcode` npm package or server-side PHP `chillerlan/php-qrcode`.
