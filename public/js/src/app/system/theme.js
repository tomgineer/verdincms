// Initialize theme toggle: sync saved preference, apply theme, and wire change handler.
export default function themeSwither() {
    let checkbox = document.querySelector('.theme-controller');
    if (!checkbox) return;

    const darkTheme = document.documentElement.getAttribute('data-default-theme') || 'dark';

    // Disable animation just for the initial state sync
    checkbox.classList.add('transition-none');

    // Load saved preference only; do not follow system/browser
    let savedTheme = localStorage.getItem('theme_mode');

    // Apply saved theme (no animation) if it exists
    if (savedTheme === darkTheme || savedTheme === 'corporate') {
        applyTheme(savedTheme, checkbox, darkTheme);
    } else {
        // No saved theme: just sync the toggle to current DOM state
        const currentTheme = document.documentElement.getAttribute('data-theme');
        checkbox.checked = (currentTheme === darkTheme);
    }

    // Re-enable transition for user interactions
    requestAnimationFrame(function () {
        checkbox.classList.remove('transition-none');
    });

    // From here on, theme changes are user-triggered; allow animation
    checkbox.addEventListener('change', function () {
        let newTheme = this.checked ? darkTheme : 'corporate';
        localStorage.setItem('theme_mode', newTheme);
        applyTheme(newTheme, this, darkTheme);
    });
}

// Apply theme to <html> and sync toggle state.
function applyTheme(theme, checkbox, darkTheme) {
    document.documentElement.setAttribute('data-theme', theme);

    // Sync toggle
    if (checkbox) {
        checkbox.checked = (theme === darkTheme);
    }
}
