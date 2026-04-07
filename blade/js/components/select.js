/**
 * Alpine.js data component for Select/ComboBox
 *
 * Usage:
 * <div x-data="uiSelect({ selected: 'value', items: [...] })">
 */
document.addEventListener('alpine:init', () => {
    Alpine.data('uiSelect', (config = {}) => ({
        open: false,
        search: '',
        selectedId: config.selected || null,
        selectedLabel: config.selectedLabel || '',
        highlightedIndex: -1,
        items: config.items || [],
        multiple: config.multiple || false,
        selectedIds: config.selectedIds || [],

        get filteredItems() {
            if (!this.search) return this.items;
            const q = this.search.toLowerCase();
            return this.items.filter(item =>
                (item.label || '').toLowerCase().includes(q) ||
                (item.supportingText || '').toLowerCase().includes(q)
            );
        },

        get displayValue() {
            if (this.multiple) {
                return this.selectedIds.length
                    ? `${this.selectedIds.length} selected`
                    : '';
            }
            return this.selectedLabel;
        },

        toggle() {
            this.open = !this.open;
            if (this.open) {
                this.highlightedIndex = -1;
                this.search = '';
            }
        },

        select(id, label) {
            if (this.multiple) {
                const idx = this.selectedIds.indexOf(id);
                if (idx > -1) {
                    this.selectedIds.splice(idx, 1);
                } else {
                    this.selectedIds.push(id);
                }
            } else {
                this.selectedId = id;
                this.selectedLabel = label;
                this.open = false;
            }
            // Dispatch change event for form integration
            this.$dispatch('select-change', {
                id: this.multiple ? this.selectedIds : id,
                label,
            });
        },

        isSelected(id) {
            if (this.multiple) {
                return this.selectedIds.includes(id);
            }
            return this.selectedId === id;
        },

        close() {
            this.open = false;
            this.search = '';
        },

        onKeydown(event) {
            const items = this.filteredItems;

            switch (event.key) {
                case 'ArrowDown':
                    event.preventDefault();
                    if (!this.open) {
                        this.open = true;
                    } else {
                        this.highlightedIndex = Math.min(
                            this.highlightedIndex + 1,
                            items.length - 1
                        );
                    }
                    break;
                case 'ArrowUp':
                    event.preventDefault();
                    this.highlightedIndex = Math.max(
                        this.highlightedIndex - 1,
                        0
                    );
                    break;
                case 'Enter':
                    event.preventDefault();
                    if (this.open && this.highlightedIndex >= 0) {
                        const item = items[this.highlightedIndex];
                        if (item && !item.disabled) {
                            this.select(item.id, item.label);
                        }
                    } else if (!this.open) {
                        this.open = true;
                    }
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
