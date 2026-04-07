/**
 * Alpine.js data component for Modal dialogs
 *
 * Usage:
 * <div x-data="uiModal()">
 *
 * Open via: $dispatch('open-modal', { id: 'my-modal' })
 * Or directly: open = true (from trigger slot)
 */
document.addEventListener('alpine:init', () => {
    Alpine.data('uiModal', (config = {}) => ({
        open: config.open || false,
        id: config.id || null,

        init() {
            if (this.id) {
                this.$watch('open', (value) => {
                    if (value) {
                        document.body.style.overflow = 'hidden';
                    } else {
                        document.body.style.overflow = '';
                    }
                });
            }
        },

        show() {
            this.open = true;
        },

        close() {
            this.open = false;
        },

        destroy() {
            document.body.style.overflow = '';
        },
    }));
});
