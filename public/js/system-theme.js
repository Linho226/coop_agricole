(function () {
    if (window.coopSystemThemeReady) return;
    window.coopSystemThemeReady = true;

    const media = window.matchMedia('(prefers-color-scheme: dark)');

    function currentSystemTheme() {
        return media.matches ? 'dark' : 'light';
    }

    function updateControls(theme) {
        document.querySelectorAll('#themeIcon, [data-theme-icon]').forEach((icon) => {
            icon.className = theme === 'dark' ? 'bi bi-moon-stars-fill' : 'bi bi-brightness-high-fill';
        });

        document.querySelectorAll('#themeToggle, [data-theme-sync]').forEach((button) => {
            const label = theme === 'dark'
                ? 'Thème système : sombre'
                : 'Thème système : clair';
            button.title = label;
            button.setAttribute('aria-label', label);
        });
    }

    function applySystemTheme() {
        const theme = currentSystemTheme();
        document.documentElement.setAttribute('data-bs-theme', theme);
        document.documentElement.style.colorScheme = theme;
        updateControls(theme);
        window.dispatchEvent(new CustomEvent('coop:theme-change', { detail: { theme } }));
    }

    window.coopApplySystemTheme = applySystemTheme;
    applySystemTheme();

    if (media.addEventListener) {
        media.addEventListener('change', applySystemTheme);
    } else if (media.addListener) {
        media.addListener(applySystemTheme);
    }

    document.addEventListener('DOMContentLoaded', () => {
        applySystemTheme();
        document.querySelectorAll('#themeToggle, [data-theme-sync]').forEach((button) => {
            button.addEventListener('click', applySystemTheme);
        });
    });
})();
