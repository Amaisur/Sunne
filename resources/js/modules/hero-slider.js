// Full-width hero slider: autoplay (paused on hover/focus and disabled
// under prefers-reduced-motion), swipe, keyboard arrows on the nav
// controls, pagination dots. The first slide is fully server-rendered and
// visible without this script running at all (progressive enhancement).

import { prefersReducedMotion } from './dom-utils.js';

const AUTOPLAY_MS = 6000;
const SWIPE_THRESHOLD = 40;
const INIT_FLAG = 'novaHeroInit';

export function init() {
    const hero = document.querySelector('[data-nova-hero]');
    if (!hero || hero.dataset[INIT_FLAG]) {
        return;
    }

    const slides = Array.from(hero.querySelectorAll('[data-hero-slide]'));
    if (slides.length < 2) {
        return;
    }
    hero.dataset[INIT_FLAG] = 'true';

    const dots = Array.from(hero.querySelectorAll('[data-nova-hero-dot]'));
    const prevBtn = hero.querySelector('[data-nova-hero-prev]');
    const nextBtn = hero.querySelector('[data-nova-hero-next]');

    let current = 0;
    let autoplayTimer = null;
    const reducedMotion = prefersReducedMotion();

    function render() {
        slides.forEach((slide, index) => {
            const isActive = index === current;
            slide.classList.toggle('is-active', isActive);
            slide.setAttribute('aria-hidden', String(!isActive));
        });
        dots.forEach((dot, index) => {
            const isActive = index === current;
            dot.classList.toggle('is-active', isActive);
            dot.setAttribute('aria-selected', String(isActive));
        });
    }

    function goTo(index) {
        current = (index + slides.length) % slides.length;
        render();
    }

    function next() {
        goTo(current + 1);
    }

    function prev() {
        goTo(current - 1);
    }

    function startAutoplay() {
        if (reducedMotion || autoplayTimer) {
            return;
        }
        autoplayTimer = window.setInterval(next, AUTOPLAY_MS);
    }

    function stopAutoplay() {
        if (autoplayTimer) {
            window.clearInterval(autoplayTimer);
            autoplayTimer = null;
        }
    }

    prevBtn && prevBtn.addEventListener('click', () => {
        prev();
        stopAutoplay();
        startAutoplay();
    });
    nextBtn && nextBtn.addEventListener('click', () => {
        next();
        stopAutoplay();
        startAutoplay();
    });
    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            goTo(index);
            stopAutoplay();
            startAutoplay();
        });
    });

    hero.addEventListener('mouseenter', stopAutoplay);
    hero.addEventListener('mouseleave', startAutoplay);
    hero.addEventListener('focusin', stopAutoplay);
    hero.addEventListener('focusout', startAutoplay);

    hero.addEventListener('keydown', (event) => {
        if (event.key === 'ArrowLeft') {
            prev();
        } else if (event.key === 'ArrowRight') {
            next();
        }
    });

    let touchStartX = null;
    hero.addEventListener(
        'touchstart',
        (event) => {
            touchStartX = event.touches[0].clientX;
        },
        { passive: true }
    );
    hero.addEventListener(
        'touchend',
        (event) => {
            if (touchStartX === null) {
                return;
            }
            const deltaX = event.changedTouches[0].clientX - touchStartX;
            if (Math.abs(deltaX) > SWIPE_THRESHOLD) {
                deltaX < 0 ? next() : prev();
            }
            touchStartX = null;
        },
        { passive: true }
    );

    render();
    startAutoplay();
}
