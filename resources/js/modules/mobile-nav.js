// Full-height mobile navigation drawer: open/close, panel-stack navigation
// (push on [data-open-panel], pop on [data-back-panel]), body scroll lock,
// focus trap, Escape + overlay close, and focus restored to the burger
// button on close.

import { trapFocus, lockBodyScroll, unlockBodyScroll } from './dom-utils.js';

const INIT_FLAG = 'novaMobileNavInit';

export function init() {
    const drawer = document.querySelector('[data-nova-mobile-drawer]');
    const trigger = document.querySelector('[data-nova-mobile-trigger]');
    const panelsWrap = document.querySelector('[data-nova-mobile-panels]');

    if (!drawer || !trigger || !panelsWrap || drawer.dataset[INIT_FLAG]) {
        return;
    }
    drawer.dataset[INIT_FLAG] = 'true';

    const closeBtn = drawer.querySelector('[data-nova-mobile-close]');
    const overlay = drawer.querySelector('[data-nova-mobile-overlay]');
    const panels = Array.from(panelsWrap.querySelectorAll('[data-mobile-panel]'));
    let panelStack = ['root'];
    let releaseFocusTrap = null;

    function showPanel(name) {
        panels.forEach((panel) => {
            const isActive = panel.getAttribute('data-mobile-panel') === name;
            panel.toggleAttribute('data-panel-active', isActive);
            if (isActive) {
                panel.scrollTop = 0;
            }
        });
    }

    function openDrawer() {
        drawer.setAttribute('data-nova-open', '');
        drawer.setAttribute('aria-hidden', 'false');
        trigger.setAttribute('aria-expanded', 'true');
        lockBodyScroll();
        panelStack = ['root'];
        showPanel('root');
        releaseFocusTrap = trapFocus(drawer);
        window.setTimeout(() => closeBtn && closeBtn.focus(), 0);
        document.addEventListener('keydown', onKeydown);
    }

    function closeDrawer() {
        drawer.removeAttribute('data-nova-open');
        drawer.setAttribute('aria-hidden', 'true');
        trigger.setAttribute('aria-expanded', 'false');
        unlockBodyScroll();
        if (releaseFocusTrap) {
            releaseFocusTrap();
            releaseFocusTrap = null;
        }
        document.removeEventListener('keydown', onKeydown);
        trigger.focus();
    }

    function onKeydown(event) {
        if (event.key === 'Escape') {
            closeDrawer();
        }
    }

    trigger.addEventListener('click', () => {
        if (drawer.hasAttribute('data-nova-open')) {
            closeDrawer();
        } else {
            openDrawer();
        }
    });

    closeBtn && closeBtn.addEventListener('click', closeDrawer);
    overlay && overlay.addEventListener('click', closeDrawer);

    panelsWrap.addEventListener('click', (event) => {
        const openTarget = event.target.closest('[data-open-panel]');
        if (openTarget) {
            const name = openTarget.getAttribute('data-open-panel');
            panelStack.push(name);
            showPanel(name);
            return;
        }

        const backTarget = event.target.closest('[data-back-panel]');
        if (backTarget && panelStack.length > 1) {
            panelStack.pop();
            showPanel(panelStack[panelStack.length - 1]);
        }
    });
}
