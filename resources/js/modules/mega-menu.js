// Products mega menu + the simple "About Us"/"Support" dropdowns and the
// language switcher panel. All three share the same open/close contract:
// a [data-nova-*-trigger] button toggles [data-nova-open] on its container
// and aria-expanded/aria-hidden on itself/the panel.
//
// Opens on hover + keyboard focus, stays open while the pointer is inside
// the panel (panel is nested inside the same container as the trigger, so
// a single mouseleave on the container covers both), closes on Escape and
// on focus/click leaving the container. A short close delay avoids
// flicker when the pointer briefly leaves the bounding box.

const CLOSE_DELAY = 150;
const INIT_FLAG = 'novaMegaMenuInit';

function wireContainer(container, trigger, panel) {
    let closeTimer = null;

    function open() {
        if (closeTimer) {
            window.clearTimeout(closeTimer);
            closeTimer = null;
        }
        closeOthers(container);
        container.setAttribute('data-nova-open', '');
        trigger.setAttribute('aria-expanded', 'true');
        if (panel) {
            panel.setAttribute('aria-hidden', 'false');
        }
    }

    function close(immediate) {
        const run = () => {
            container.removeAttribute('data-nova-open');
            trigger.setAttribute('aria-expanded', 'false');
            if (panel) {
                panel.setAttribute('aria-hidden', 'true');
            }
        };

        if (immediate) {
            run();
        } else {
            closeTimer = window.setTimeout(run, CLOSE_DELAY);
        }
    }

    container.addEventListener('mouseenter', open);
    container.addEventListener('mouseleave', () => close(false));
    trigger.addEventListener('focus', open);
    trigger.addEventListener('click', () => {
        if (container.hasAttribute('data-nova-open')) {
            close(true);
        } else {
            open();
        }
    });

    container.addEventListener('focusout', (event) => {
        if (!container.contains(event.relatedTarget)) {
            close(true);
        }
    });

    container.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            close(true);
            trigger.focus();
        }
    });

    return { container, close };
}

let openContainers = [];

function closeOthers(except) {
    openContainers.forEach((entry) => {
        if (entry.container !== except) {
            entry.close(true);
        }
    });
}

export function init() {
    if (document.body.dataset[INIT_FLAG]) {
        return;
    }
    document.body.dataset[INIT_FLAG] = 'true';

    openContainers = [];

    document.querySelectorAll('[data-nova-mega-trigger]').forEach((trigger) => {
        const container = trigger.closest('[data-nova-nav-item]');
        if (!container) {
            return;
        }
        const panelId = trigger.getAttribute('aria-controls');
        const panel = panelId ? document.getElementById(panelId) : null;
        openContainers.push(wireContainer(container, trigger, panel));
    });

    document.querySelectorAll('[data-nova-dropdown-trigger]').forEach((trigger) => {
        const container = trigger.closest('[data-nova-nav-item], [data-nova-dropdown]');
        if (!container) {
            return;
        }
        const panelId = trigger.getAttribute('aria-controls');
        const panel = panelId ? document.getElementById(panelId) : null;
        openContainers.push(wireContainer(container, trigger, panel));
    });

    document.addEventListener('click', (event) => {
        const insideAny = openContainers.some((entry) => entry.container.contains(event.target));
        if (!insideAny) {
            closeOthers(null);
        }
    });
}
