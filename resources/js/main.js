// NovaTheme entry point. Loaded as <script type="module"> (natively
// deferred, so the DOM is already parsed by the time this runs) via the
// "Ceres::Script.AfterScriptsLoaded" container - see
// src/Providers/ScriptProvider.php and resources/views/assets/ScriptTag.twig.
//
// Each module is self-guarding (checks for its own root element and a
// data-*Init flag) so calling init() when the relevant markup isn't on the
// page (e.g. the hero slider on a category page) is always a safe no-op,
// and re-running main() never double-initialises anything.

import { init as initStickyHeader } from './modules/sticky-header.js';
import { init as initMegaMenu } from './modules/mega-menu.js';
import { init as initMobileNav } from './modules/mobile-nav.js';
import { init as initHeroSlider } from './modules/hero-slider.js';
import { init as initContactModal } from './modules/contact-modal.js';
import { init as initFooterAccordion } from './modules/footer-accordion.js';
import { init as initFloatingActions } from './modules/floating-actions.js';
import { init as initScrollAnimations } from './modules/scroll-animations.js';

function main() {
    if (document.documentElement.dataset.novaThemeInit) {
        return;
    }
    document.documentElement.dataset.novaThemeInit = 'true';

    initStickyHeader();
    initMegaMenu();
    initMobileNav();
    initHeroSlider();
    initContactModal();
    initFooterAccordion();
    initFloatingActions();
    initScrollAnimations();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', main, { once: true });
} else {
    main();
}
