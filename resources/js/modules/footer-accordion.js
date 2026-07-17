// Mobile footer accordion. Toggling [data-open] is harmless on desktop -
// _footer.scss forces the column list visible with `!important` above the
// "md" breakpoint regardless of this attribute.

const INIT_FLAG = 'novaFooterAccordionInit';

export function init() {
    const wrap = document.querySelector('[data-nova-footer-accordion]');
    if (!wrap || wrap.dataset[INIT_FLAG]) {
        return;
    }
    wrap.dataset[INIT_FLAG] = 'true';

    wrap.querySelectorAll('[data-footer-toggle]').forEach((toggle) => {
        toggle.addEventListener('click', () => {
            const group = toggle.closest('[data-footer-group]');
            if (!group) {
                return;
            }
            const isOpen = group.hasAttribute('data-open');
            group.toggleAttribute('data-open', !isOpen);
            toggle.setAttribute('aria-expanded', String(!isOpen));
        });
    });
}
