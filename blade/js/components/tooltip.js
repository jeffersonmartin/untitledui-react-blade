/**
 * Alpine.js data component for Tooltips
 *
 * For simple tooltips, inline x-data is sufficient.
 * This component is for programmatic tooltip management.
 *
 * Usage:
 * <span x-data="uiTooltip({ delay: 300 })">
 */
document.addEventListener('alpine:init', () => {
    Alpine.data('uiTooltip', (config = {}) => ({
        show: false,
        delay: config.delay || 300,
        _timeout: null,

        onEnter() {
            this._timeout = setTimeout(() => {
                this.show = true;
            }, this.delay);
        },

        onLeave() {
            clearTimeout(this._timeout);
            this.show = false;
        },

        destroy() {
            clearTimeout(this._timeout);
        },
    }));
});
