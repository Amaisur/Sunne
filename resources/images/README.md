# NovaTheme placeholder assets

Every image the plugin ships with today is a **generated SVG placeholder**
(a labelled colour block showing the filename and target dimensions) so the
homepage renders correctly out of the box. None of it is final artwork -
replace it with the client's real photography before launch.

## How to replace an asset

1. Export the real photo as WebP (or AVIF) at the dimensions below.
2. Save it into the same folder **using the same base filename**, e.g.
   `hero/hero-monitor-arms-desktop.webp`.
3. Update the one reference to that filename:
   - Hero slides, promo cards, company intro, insights, contact background,
     mega menu group images, footer group logos -> edit the matching entry
     in `src/Config/ContentConfig.php` (search for the current `.svg` path).
   - The header/mobile-drawer logo -> edit the two `logo/logo-placeholder.svg`
     references in `resources/views/partials/Header.twig` and
     `resources/views/partials/MobileMenu.twig`.
4. Re-run the CSS/asset build if you also changed anything in `resources/scss`
   (see the root `README.md`).

No other template or SCSS changes are required - every `<img>`/`<source>`
already uses `width`/`height`, `loading`, and `decoding` attributes sized for
real photography, so swapping the file in place will not shift layout.

## Asset list (target production filenames + recommended specs)

| File | Recommended size | Aspect | Used in |
|---|---|---|---|
| `logo/logo-placeholder.webp` (or `.svg` for a vector logo) | 296x72 | - | Header, mobile drawer |
| `hero/hero-monitor-arms-desktop.webp` | 1920x800 | ~2.4:1 | Hero slide 1 (desktop, eager/LCP) |
| `hero/hero-monitor-arms-mobile.webp` | 960x1200 | 4:5 | Hero slide 1 (mobile) |
| `hero/hero-gas-spring-arms-desktop.webp` | 1920x800 | ~2.4:1 | Hero slide 2 (desktop) |
| `hero/hero-gas-spring-arms-mobile.webp` | 960x1200 | 4:5 | Hero slide 2 (mobile) |
| `hero/hero-tv-carts-desktop.webp` | 1920x800 | ~2.4:1 | Hero slide 3 (desktop) |
| `hero/hero-tv-carts-mobile.webp` | 960x1200 | 4:5 | Hero slide 3 (mobile) |
| `hero/hero-medical-carts-desktop.webp` | 1920x800 | ~2.4:1 | Hero slide 4 (desktop) |
| `hero/hero-medical-carts-mobile.webp` | 960x1200 | 4:5 | Hero slide 4 (mobile) |
| `promo/promo-new-arrivals-desktop.webp` | 960x640 | 3:2 | Promo tile 1 (desktop) |
| `promo/promo-new-arrivals-mobile.webp` | 750x1000 | 3:4 | Promo tile 1 (mobile) |
| `promo/promo-marketing-support-desktop.webp` | 960x640 | 3:2 | Promo tile 2 (desktop) |
| `promo/promo-marketing-support-mobile.webp` | 750x1000 | 3:4 | Promo tile 2 (mobile) |
| `intro/company-introduction.webp` | 1920x900 | ~2.1:1 | Company introduction section |
| `insights/article-office-chair-guide.webp` | 480x320 | 3:2 | Insights card 1 |
| `insights/article-bike-rack.webp` | 480x320 | 3:2 | Insights card 2 |
| `insights/article-gaming-cockpit.webp` | 480x320 | 3:2 | Insights card 3 |
| `insights/article-trade-show.webp` | 480x320 | 3:2 | Insights card 4 |
| `contact/contact-background.webp` | 1920x960 | 2:1 | Contact section background |
| `megamenu/group-office-solutions.webp` | 720x480 | 3:2 | Products mega menu - Office Solutions |
| `megamenu/group-home-solutions.webp` | 720x480 | 3:2 | Products mega menu - Home Solutions |
| `megamenu/group-professional-solutions.webp` | 720x480 | 3:2 | Products mega menu - Professional Solutions |
| `megamenu/group-gaming-solutions.webp` | 720x480 | 3:2 | Products mega menu - Gaming Solutions |
| `megamenu/group-new-categories.webp` | 720x480 | 3:2 | Products mega menu - New Categories |
| `footer/group-logo-1.webp` .. `group-logo-4.webp` | 280x96 | ~2.9:1 | Footer group/related-brand logos |

Add or remove rows here as you add/remove entries in `ContentConfig.php` -
this table should always describe exactly what's referenced in code.
