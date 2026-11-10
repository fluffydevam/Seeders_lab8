import '@fontsource-variable/jetbrains-mono';
import './bootstrap';

const root = document.documentElement;
const themeToggle = document.querySelector('[data-theme-toggle]');

if (themeToggle) {
    const syncPressedState = () => {
        themeToggle.setAttribute('aria-pressed', root.classList.contains('dark') ? 'true' : 'false');
    };

    syncPressedState();

    themeToggle.addEventListener('click', () => {
        const isDark = root.classList.toggle('dark');

        localStorage.setItem('theme', isDark ? 'dark' : 'light');
        syncPressedState();
    });

    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (event) => {
        if (localStorage.getItem('theme') === null) {
            root.classList.toggle('dark', event.matches);
            syncPressedState();
        }
    });
}
