// Generic accessible modal open/close (any [data-nova-modal-trigger="id"])
// plus the contact form's client-side validation and loading/success
// states. The submit target is read from data-form-action on the form
// (see ContentConfig::contact()["formActionUrl"]) - nothing is hardcoded.

import { trapFocus } from './dom-utils.js';

const INIT_FLAG = 'novaModalInit';
const EMAIL_RE = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

function wireModal(modal) {
    const closeBtn = modal.querySelector('[data-nova-modal-close]');
    const overlay = modal.querySelector('[data-nova-modal-overlay]');
    let releaseFocusTrap = null;
    let lastFocused = null;

    function open() {
        lastFocused = document.activeElement;
        modal.setAttribute('data-nova-open', '');
        modal.setAttribute('aria-hidden', 'false');
        releaseFocusTrap = trapFocus(modal);
        window.setTimeout(() => {
            const firstField = modal.querySelector('input, textarea, button');
            firstField && firstField.focus();
        }, 0);
        document.addEventListener('keydown', onKeydown);
    }

    function close() {
        modal.removeAttribute('data-nova-open');
        modal.setAttribute('aria-hidden', 'true');
        if (releaseFocusTrap) {
            releaseFocusTrap();
            releaseFocusTrap = null;
        }
        document.removeEventListener('keydown', onKeydown);
        if (lastFocused && typeof lastFocused.focus === 'function') {
            lastFocused.focus();
        }
    }

    function onKeydown(event) {
        if (event.key === 'Escape') {
            close();
        }
    }

    closeBtn && closeBtn.addEventListener('click', close);
    overlay && overlay.addEventListener('click', close);

    return { open, close };
}

function validateField(field, messages) {
    const wrapper = field.closest('[data-nova-field]');
    const errorEl = wrapper ? wrapper.querySelector('.nova-form__error') : null;
    let message = '';

    if (field.required && !field.value.trim()) {
        message = messages.required;
    } else if (field.type === 'email' && field.value.trim() && !EMAIL_RE.test(field.value.trim())) {
        message = messages.email;
    }

    if (wrapper) {
        wrapper.classList.toggle('has-error', Boolean(message));
    }
    if (errorEl) {
        errorEl.textContent = message;
        errorEl.hidden = !message;
    }

    return !message;
}

function wireForm(form) {
    const fields = Array.from(form.querySelectorAll('input, textarea'));
    const successEl = form.parentElement.querySelector('[data-nova-form-success]');
    const messages = {
        required: form.dataset.msgRequired || 'This field is required.',
        email: form.dataset.msgEmail || 'Please enter a valid email address.',
        generic: form.dataset.msgGeneric || 'Something went wrong. Please try again.',
    };

    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        const isValid = fields.map((field) => validateField(field, messages)).every(Boolean);
        if (!isValid) {
            const firstInvalid = form.querySelector('.has-error input, .has-error textarea');
            firstInvalid && firstInvalid.focus();
            return;
        }

        const action = form.dataset.formAction;
        form.setAttribute('data-loading', '');

        try {
            if (action && action !== '#') {
                const response = await fetch(action, { method: 'POST', body: new FormData(form) });
                if (!response.ok) {
                    throw new Error('Request failed');
                }
            } else {
                // No form handler configured yet - simulate success so the
                // UI can be reviewed before wiring up a real endpoint.
                await new Promise((resolve) => window.setTimeout(resolve, 500));
            }

            form.hidden = true;
            if (successEl) {
                successEl.hidden = false;
            }
        } catch (error) {
            const wrapper = form.querySelector('[data-nova-field]');
            const errorEl = wrapper ? wrapper.querySelector('.nova-form__error') : null;
            if (errorEl) {
                errorEl.textContent = messages.generic;
                errorEl.hidden = false;
            }
        } finally {
            form.removeAttribute('data-loading');
        }
    });

    fields.forEach((field) => {
        field.addEventListener('blur', () => validateField(field, messages));
    });
}

export function init() {
    if (document.body.dataset[INIT_FLAG]) {
        return;
    }
    document.body.dataset[INIT_FLAG] = 'true';

    const modals = new Map();
    document.querySelectorAll('[data-nova-modal]').forEach((modal) => {
        modals.set(modal.id, wireModal(modal));
        const form = modal.querySelector('[data-nova-contact-form]');
        if (form) {
            wireForm(form);
        }
    });

    document.querySelectorAll('[data-nova-modal-trigger]').forEach((trigger) => {
        trigger.addEventListener('click', () => {
            const targetId = trigger.getAttribute('data-nova-modal-trigger');
            const modal = modals.get(targetId);
            modal && modal.open();
        });
    });
}
