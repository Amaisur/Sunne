// Subtle scroll-triggered reveal for elements marked [data-nova-reveal].
// Uses IntersectionObserver (no scroll listeners, no layout thrashing) and
// is a no-op under prefers-reduced-motion - matching elements are simply
// shown immediately via the .nova-reveal--static fallback class.

import { prefersReducedMotion } from './dom-utils.js';

const INIT_FLAG = 'novaScrollAnimInit';

export function init() {
    if (document.body.dataset[INIT_FLAG]) {
        return;
    }
    document.body.dataset[INIT_FLAG] = 'true';

    const targets = Array.from(document.querySelectorAll('[data-nova-reveal]'));
    if (targets.length === 0) {
        return;
    }

    if (prefersReducedMotion() || !('IntersectionObserver' in window)) {
        targets.forEach((el) => el.classList.add('nova-reveal--static'));
        return;
    }

    targets.forEach((el) => el.classList.add('nova-reveal'));

    const observer = new IntersectionObserver(
        (entries, obs) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('nova-reveal--visible');
                    obs.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.15, rootMargin: '0px 0px -40px 0px' }
    );

    targets.forEach((el) => observer.observe(el));
}
