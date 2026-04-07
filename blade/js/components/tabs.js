/**
 * Alpine.js data component for Tabs
 *
 * Usage:
 * <div x-data="uiTabs({ active: 'tab-1' })">
 */
document.addEventListener('alpine:init', () => {
    Alpine.data('uiTabs', (config = {}) => ({
        activeTab: config.active || '',

        setTab(name) {
            this.activeTab = name;
        },

        isActive(name) {
            return this.activeTab === name;
        },
    }));
});
