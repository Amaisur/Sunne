# NovaTheme - Custom Homepage & Header Plugin for PlentyONE / Ceres

A PlentyONE plugin that adds a fully custom homepage and header (hero
slider, mega menu, promo tiles, company intro, insights, contact section,
footer, floating actions) to an existing Ceres shop, styled after a modern
B2B manufacturer layout. It ships with neutral placeholder copy, imagery and
branding so a client's real assets can be dropped in later.

**No product, category, search, cart, checkout, account or legal page is
touched.** Only the homepage, the site header and the footer change.

---

## 1. Integration approach (read this first)

Ceres (plentymarkets' shop template plugin) exposes named **layout
containers** at fixed points in its own templates. When a container is
non-empty, Ceres renders whatever the container returns *instead of* its own
default markup for that spot. This is confirmed directly in Ceres' source:

- `Ceres/Homepage/Homepage.twig` -> checks container `Ceres::Homepage`,
  falls back to `MarketingHomepage.twig` if empty.
- `Ceres/PageDesign/Partials/Header/Header.twig` -> checks container
  `Ceres::Header`, falls back to `DefaultHeader.twig` if empty.
- `Ceres/PageDesign/Partials/Footer.twig` -> checks container
  `Ceres::Footer`, falls back to its own default footer markup if empty.
- The document `<head>`/`<script>` loading points are also containers:
  `Ceres::Template.Style` and `Ceres::Script.AfterScriptsLoaded`.

NovaTheme fills exactly those five containers via `plugin.json`
`dataProviders[].defaultLayoutContainer` - a single PHP class per container,
each rendering one Twig template (see `src/Providers/*.php`). **Nothing in
Ceres is overridden, forked or replaced**, no route is registered for `/`,
and the outer `<html>/<head>/<body>` document (`Ceres/PageDesign.twig`) is
untouched - so cart state, customer/login state, search, language/currency
switching, breadcrumbs, modals and the Vue app bootstrap all keep working
exactly as they do today. This is why product/category/search/cart/
checkout/account/legal pages are unaffected: none of them read the
`Ceres::Homepage` or `Ceres::Header`/`Ceres::Footer` containers on the
homepage-specific ones, and the header/footer containers only change what's
*inside* the existing `<header>`/footer wrapper on every page (that's the
one intentional, spec-required exception: header and footer are shared
chrome, so they change everywhere, exactly like installing a different
Ceres header template would).

Because `defaultLayoutContainer` links a data provider to its container
automatically, **no manual container configuration in the backend is
required** - installing and activating the plugin is enough (see
"Deployment" below).

### Why not a custom route for `/`?

Overriding plentymarkets' routing for the homepage would mean
re-implementing SEO URL handling, language/shop resolution, canonical tags
and the "which category is the homepage" setting from scratch, and it would
risk conflicting with Ceres' own homepage detection
(`services.template.isHome()`) used elsewhere in the template chain. The
container mechanism above is the documented, supported extension point for
exactly this use case, so it is used instead.

---

## 2. Plugin structure

```
plugin.json
src/
  Providers/
    NovaThemeServiceProvider.php   # required boot/register class (no-op; wiring is declarative)
    HeaderProvider.php             # -> Ceres::Header
    HomepageProvider.php           # -> Ceres::Homepage
    FooterProvider.php             # -> Ceres::Footer
    StyleProvider.php              # -> Ceres::Template.Style
    ScriptProvider.php             # -> Ceres::Script.AfterScriptsLoaded
  Config/
    ContentConfig.php              # single source of truth for all copy/links/images
resources/
  views/
    Homepage.twig                  # assembles the section partials below
    sections/
      Hero.twig
      PromoTiles.twig
      CompanyIntro.twig
      Insights.twig
      Contact.twig
    partials/
      Header.twig
      MegaMenu.twig
      MobileMenu.twig
      HeaderControls.twig
      ContactModal.twig
      FloatingActions.twig
      Footer.twig
    macros/
      Helpers.twig                 # category/item link resolution macro
    assets/
      StyleTag.twig
      ScriptTag.twig
  scss/                            # _variables, _base, _header, _mega-menu, _mobile-menu,
                                    # _hero, _promo, _company-intro, _insights, _contact,
                                    # _modal, _footer, _floating-actions, _responsive, main.scss
  css/
    main.css / main.min.css        # compiled output (committed, no build step required)
  js/
    modules/                       # one file per feature (see section 5)
    main.js                        # entry point, loads as <script type="module">
  images/                          # placeholder assets, see images/README.md
  lang/
    en/NovaTheme.properties
    de/NovaTheme.properties
```

---

## 3. Installation

1. Copy this whole folder into your plentymarkets plugin workspace as
   `NovaTheme` (e.g. via the plentymarkets Plugin Manager's Git/upload
   flow, or by pushing it to the plugin repository plentymarkets is
   configured to pull from).
2. In the backend, go to **Plugins -> Plugin overview** and confirm
   `NovaTheme` appears with no errors, and that `Ceres` is already
   installed (NovaTheme depends on it - see `plugin.json` `require`).
3. Add `NovaTheme` to the plugin set that serves your live shop.

No composer install, npm install, or database migration is needed - this
plugin has no backend/API code, only templates, assets and declarative
container wiring.

---

## 4. Build instructions (only needed if you edit the SCSS)

The compiled `resources/css/main.css` / `main.min.css` are committed, so the
plugin works as-is. If you change anything under `resources/scss/`, rebuild
with [Dart Sass](https://sass-lang.com/dart-sass):

```bash
npx sass resources/scss/main.scss resources/css/main.css --style=expanded
npx sass resources/scss/main.scss resources/css/main.min.css --style=compressed
```

`resources/views/assets/StyleTag.twig` loads `css/main.min.css` (the
minified, production build) - keep that file up to date after every SCSS
change. `resources/js/` needs no build step: it's plain ES modules loaded
directly via `<script type="module">`.

---

## 5. Plugin-set deployment

1. In the plentymarkets backend, go to **Plugins -> Plugin set overview**.
2. Open the plugin set assigned to your shop's webstore.
3. Add `NovaTheme` to the set. Order relative to Ceres does not matter for
   the container mechanism (unlike raw template overriding, containers are
   resolved by container key, not by plugin load order), but conventionally
   place it after Ceres.
4. Save and **deploy** the plugin set. Deployment recompiles Ceres' Twig
   cache, which is required for the new container content to appear.
5. Clear the shop cache if you don't see changes immediately (Plugin set
   overview -> the three-dot menu -> "Clear cache", or via the
   Plugins -> Plugin overview -> Ceres -> cache clear button).

---

## 6. Assigning the homepage

Nothing extra to configure: whatever category is currently set as your
shop's homepage/startpage (**Setup -> Client -> select client -> Startpage**,
or the category marked as homepage in **Item -> Categories**) keeps working
exactly as before - NovaTheme only changes what Ceres renders *when* that
page is displayed, via the `Ceres::Homepage` container. There is nothing to
re-point.

---

## 7. Replacing placeholder assets

See [`resources/images/README.md`](resources/images/README.md) for the full
asset list (target filenames + recommended dimensions). In short:

1. Drop a real `.webp`/`.avif` photo into the matching `resources/images/*`
   subfolder, keeping (or updating) the filename.
2. Update the one line in `src/Config/ContentConfig.php` (or
   `partials/Header.twig` / `partials/MobileMenu.twig` for the logo) that
   references the old filename.
3. Replace copy directly in `src/Config/ContentConfig.php` - every heading,
   description, link and button label used across the header, mega menu,
   hero, promo tiles, intro, insights, contact section, footer and floating
   actions lives in that one file (see section 8).

---

## 8. Content configuration model

All structured content (navigation, mega menu groups, hero slides, promo
cards, company intro, insights cards, contact section, footer columns,
social links, floating actions, contact form fields) lives in
`src/Config/ContentConfig.php` as plain PHP arrays returned from static
methods, and is passed into the relevant Twig template by the matching
Provider class.

**Why a PHP class and not the plugin configuration UI:** the plentymarkets
backend plugin-configuration screen only supports flat string/number/
boolean/select fields. It has no support for repeatable groups or nested
structures, so it cannot model "N mega-menu groups, each with M categories,
each with P links" or "N hero slides". A plain PHP class is the supported
middle ground for this kind of content in a Ceres theme/template plugin -
it's fully version-controlled, diffable, and requires no database.

Every link entry supports two shapes:

```php
['label' => 'Office Solutions', 'url' => '#', 'categoryId' => null]
```

- If `categoryId` is set to a real category ID, the link resolves to that
  category's real, language- and shop-aware URL via
  `services.category.get()` / `services.category.getURL()` (see
  `resources/views/macros/Helpers.twig`) - exactly the same services Ceres'
  own footer uses.
- Otherwise it falls back to the static `url` value (`#` by default).

This means you can wire real categories in incrementally without touching
any Twig file - just fill in `categoryId` values in `ContentConfig.php`.

---

## 9. How category/item URLs are connected

- Every navigation, mega-menu, footer and insights link accepts an optional
  `categoryId`, resolved through `services.category.get($id, $lang)` and
  `services.category.getURL($category)` - the same repository/service Ceres
  itself uses, so URLs automatically respect the current language, the
  current shop/webstore, and any SEO URL configured for that category.
- No production domain is hardcoded anywhere; all links are relative
  (`services.category.getURL()` returns a relative, shop-aware path).
- Legal links in the footer (`urls.privacyPolicy`, `urls.legalDisclosure`,
  `urls.cancellationRights`, `urls.cancellationForm`,
  `urls.declarationOfAccessibility`, `urls.gtc`, `urls.contact`) reuse
  Ceres' own resolved URL objects rather than being re-implemented.
- If you want a homepage tile or insights card to show live item data
  (image/price/availability), don't hand-roll it here - embed Ceres' own
  widget component instead, e.g.
  `{{ component("Ceres::Widgets.Common.ItemListWidget", { ... }) }}`, which
  already handles price formatting, net/gross display and availability
  without duplicating any cart/pricing logic.

---

## 10. JavaScript

Plain ES modules, no framework, no bundler required, loaded once via
`<script type="module">` (natively deferred) from the
`Ceres::Script.AfterScriptsLoaded` container:

| Module | Responsibility |
|---|---|
| `modules/dom-utils.js` | shared focus-trap / body-scroll-lock / reduced-motion helpers |
| `modules/sticky-header.js` | transparent-over-hero -> solid-on-scroll header transition |
| `modules/mega-menu.js` | desktop mega menu + simple dropdowns + language panel (hover/focus/Escape/outside-click) |
| `modules/mobile-nav.js` | full-height drawer, panel-stack navigation, scroll lock, focus trap |
| `modules/hero-slider.js` | autoplay, pause on hover/focus, swipe, keyboard arrows, reduced-motion |
| `modules/contact-modal.js` | generic modal open/close + contact form validation/loading/success |
| `modules/footer-accordion.js` | mobile footer column accordion |
| `modules/floating-actions.js` | floating action bar init hook (badge counts, once a real compare/inquiry plugin is wired up) |
| `modules/scroll-animations.js` | IntersectionObserver-based reveal-on-scroll for `[data-nova-reveal]` elements |

Every module: guards on its root element existing, sets a `data-*Init` flag
before wiring listeners (safe to call `init()` more than once), never
declares a global variable, and checks `prefers-reduced-motion` where
relevant (autoplay and scroll-reveal are both disabled/skipped under
reduced motion; CSS transition durations also collapse to ~0 globally via
the `--nova-transition-*` custom properties).

---

## 11. Testing checklist

**Functional**
- [ ] Homepage (`/`) renders the NovaTheme hero/promo/intro/insights/contact
      sections; header and footer are the NovaTheme versions.
- [ ] A product page, category page, search results page, cart, checkout,
      an account page and a legal page (privacy policy etc.) all render
      unchanged except for the shared header/footer.
- [ ] Adding an item to the basket, logging in/registering, and searching
      from the new header all work exactly as before (they call the same
      Ceres Vue components).
- [ ] Switching language/currency/shipping country from the header works
      and preserves the current page.

**Header / navigation**
- [ ] Mega menu opens on hover and on keyboard focus, stays open while the
      pointer moves into the panel, closes on Escape and on outside click.
- [ ] Header is transparent over the hero on the homepage and turns solid
      once scrolled; on every other page it is solid immediately.
- [ ] Mobile drawer: opens/closes via burger, overlay and Escape; body
      scroll is locked while open; nested panels (Products -> group ->
      links) push/pop correctly with the back button; focus is trapped
      inside the drawer and restored to the burger on close.

**Homepage sections**
- [ ] Hero: first slide is visible immediately without JS; autoplay runs
      and pauses on hover/focus; arrow keys, swipe and pagination dots all
      change slides; motion stops under `prefers-reduced-motion`.
- [ ] Promo tiles stack on mobile, sit side-by-side on desktop, and zoom
      slightly on hover.
- [ ] Insights cards scroll horizontally on mobile and form a 4-up grid on
      desktop.
- [ ] Contact section's primary button opens the modal; modal traps focus,
      closes on Escape/overlay/close button, validates required fields and
      email format, shows a loading state on submit and a success state
      after.
- [ ] Floating action bar is visible on the homepage, does not appear on
      other page types, and its "Contact Us" action opens the same modal.

**Responsive** - check each of ~1440px, 1200px, 992px, 768px and 480px
widths for the header, mega menu, hero, promo tiles, insights and footer.

**Accessibility**
- [ ] Tab through the whole header/mega menu/mobile drawer/contact modal
      with a keyboard only; confirm visible focus rings throughout.
- [ ] Run an automated check (axe, Lighthouse) against the homepage.
- [ ] Confirm exactly one `<h1>` on the homepage (the first hero slide's
      heading).

**Performance**
- [ ] Lighthouse/PageSpeed: confirm the first hero image is the LCP
      element and is not lazy-loaded; confirm no other blocking third-party
      scripts were introduced.

---

## 12. Known limitations / notes

- **Mega menu / footer / insights content is static PHP config, not a CMS.**
  There is no merchant-facing UI to edit hero slides or mega-menu groups;
  editing `ContentConfig.php` is a developer task. This is a deliberate
  trade-off - see section 8.
- **plentyMarkets/Ceres has no built-in blog module.** The "Insights &
  Guides" section links to Content-type categories (via `categoryId`) or
  static placeholder URLs; it does not pull from a real article/CMS entity
  because none exists in core Ceres.
- **"Inquiry" and "Compare" floating actions are not core Ceres features.**
  No bundled RFQ or product-comparison module ships with Ceres, so those two
  actions render as configurable links with a static "0" count
  (`modules/floating-actions.js` documents where to wire a real count once
  a compare/inquiry plugin is installed). "Contact Us" is fully functional
  (opens the real contact modal).
- **Floating actions and the contact modal are scoped to the homepage
  only**, per the requirement not to change the layout of any other page
  type. If you want them site-wide, add a second data provider targeting
  the `Ceres::PageDesign.AfterOpeningBodyTag` container instead.
- **Ceres' own `<mobile-navigation>` Vue component still exists in the DOM**
  (it's rendered by `Header.twig` outside the container we fill), but
  nothing in the NovaTheme header dispatches the Vuex action that opens it,
  so it stays dormant and never conflicts with the custom mobile drawer.
- **The contact form has no backend handler out of the box.** Point
  `ContentConfig::contact()['formActionUrl']` at your own endpoint or a
  PlentyONE mail-form handler; until then, submitting the form simulates a
  success state so the UI/UX can be reviewed end-to-end.
- **SCSS uses `@import`**, which Dart Sass has deprecated in favour of
  `@use`/`@forward`. It still compiles today (see the build command); a
  future Dart Sass major version will require migrating to `@use`.
# Sunne
