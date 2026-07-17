// Sticky header: transparent-over-hero on the homepage, solid everywhere
// else, with a smooth transition once the user scrolls. Uses
// IntersectionObserver (no scroll-event layout thrashing) for the
// transparent/solid switch, and a lightweight rAF-throttled scroll listener
// only for the "shrink header height" micro-state.

const INIT_FLAG = 'novaStickyHeaderInit';

export function init() {
    const header = document.querySelector('[data-nova-header]');
    if (!header || header.dataset[INIT_FLAG]) {
        return;
    }
    header.dataset[INIT_FLAG] = 'true';

    const hero = document.querySelector('[data-nova-hero]');

    if (!hero) {
        header.classList.add('is-solid');
    } else {
        header.classList.add('is-transparent');

        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver(
                (entries) => {
                    entries.forEach((entry) => {
                        header.classList.toggle('is-solid', !entry.isIntersecting);
                    });
                },
                { rootMargin: `-${header.offsetHeight}px 0px 0px 0px`, threshold: 0 }
            );
            observer.observe(hero);
        } else {
            header.classList.add('is-solid');
        }
    }

    let ticking = false;
    window.addEventListener(
        'scroll',
        () => {
            if (ticking) {
                return;
            }
            ticking = true;
            window.requestAnimationFrame(() => {
                header.classList.toggle('is-scrolled', window.scrollY > 10);
                ticking = false;
            });
        },
        { passive: true }
    );
}
