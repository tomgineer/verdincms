export default function themeSwither() {
    let checkbox = document.querySelector('.theme-controller');
    if (!checkbox) return;

    // Disable animation just for the initial state sync
    checkbox.classList.add('transition-none');

    // Load saved preference or follow system
    let savedTheme = localStorage.getItem('theme_mode');
    let prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

    let initialTheme;
    if (savedTheme === 'dark' || savedTheme === 'autumn') {
        initialTheme = savedTheme;
    } else {
        initialTheme = prefersDark ? 'dark' : 'autumn';
    }

    // Apply initial theme (no animation)
    applyTheme(initialTheme, checkbox);

    // Re-enable transition for user interactions
    requestAnimationFrame(function () {
        checkbox.classList.remove('transition-none');
    });

    // From here on, theme changes are user-triggered → allow animation
    checkbox.addEventListener('change', function () {
        let newTheme = this.checked ? 'dark' : 'autumn';
        localStorage.setItem('theme_mode', newTheme);
        applyTheme(newTheme, this);
    });
}

function applyTheme(theme, checkbox) {
    const baseUrl = document.querySelector('meta[name="base-url"]')?.content;
    if (!baseUrl) return;

    const basePath = `${baseUrl}gfx/`;

    // Apply theme to <html>
    document.documentElement.setAttribute('data-theme', theme);

    // Sync toggle
    if (checkbox) {
        checkbox.checked = (theme === 'dark');
    }

    // Update logo
    let logos = document.querySelectorAll('[data-logo]');

    if (logos.length) {
        logos.forEach(el => {
            el.src = theme === 'dark'
                ? `${basePath}logo.svg`
                : `${basePath}logo_light.svg`;
        });
    }
}