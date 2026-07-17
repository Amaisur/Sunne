// Floating action bar. Modal-triggering items (e.g. "Contact Us") are
// already wired generically by contact-modal.js via [data-nova-modal-trigger].
// This module only owns the optional count badges - "inquiry"/"compare"
// are not core Ceres features (no bundled RFQ/compare module ships with
// Ceres), so counts stay at their static server-rendered "0" until a real
// inquiry/compare plugin is installed and wired up here.

const INIT_FLAG = 'novaFloatingActionsInit';

export function init() {
    const bar = document.querySelector('[data-nova-floating-actions]');
    if (!bar || bar.dataset[INIT_FLAG]) {
        return;
    }
    bar.dataset[INIT_FLAG] = 'true';

    // Example of how a real integration would update a badge once wired up:
    // const count = document.querySelector('[data-nova-count="compare"]');
    // if (count) { count.textContent = String(compareService.getCount()); }
}
