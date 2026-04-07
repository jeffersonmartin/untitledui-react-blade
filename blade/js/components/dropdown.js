/**
 * Alpine.js data component for Dropdown menus
 *
 * Usage:
 * <div x-data="uiDropdown()">
 */
document.addEventListener('alpine:init', () => {
    Alpine.data('uiDropdown', () => ({
        open: false,
        highlightedIndex: -1,

        toggle() {
            this.open = !this.open;
            if (this.open) {
                this.highlightedIndex = -1;
            }
        },

        close() {
            this.open = false;
        },

        onKeydown(event) {
            const items = this.$el.querySelectorAll('[role="menuitem"]:not([aria-disabled="true"])');

            switch (event.key) {
                case 'ArrowDown':
                    event.preventDefault();
                    this.highlightedIndex = Math.min(
                        this.highlightedIndex + 1,
                        items.length - 1
                    );
                    items[this.highlightedIndex]?.focus();
                    break;
                case 'ArrowUp':
                    event.preventDefault();
                    this.highlightedIndex = Math.max(
                        this.highlightedIndex - 1,
                        0
                    );
                    items[this.highlightedIndex]?.focus();
                    break;
                case 'Escape':
                    this.close();
                    break;
                case 'Tab':
                    this.close();
                    break;
            }
        },
    }));
});
