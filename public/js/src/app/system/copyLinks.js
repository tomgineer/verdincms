/**
 * Copies the article URL to clipboard when clicking the "Copy" button.
 * Shows a friendly confirmation using a toast or alert fallback.
 */
export default function initCopyUrl() {
    const button = document.querySelector('[data-js-copy-url]');
    const input = button?.closest('div').querySelector('input');

    if (!button || !input) return;

    button.addEventListener('click', async () => {
        try {
            await navigator.clipboard.writeText(input.value);

            // Optional: DaisyUI toast (if you use <div class="toast"> in layout)
            const toast = document.createElement('div');
            toast.className = 'alert alert-success shadow-lg fixed bottom-4 right-4 w-auto max-w-sm z-50';
            toast.innerHTML = `
                <span class="font-semibold">Αντιγράφηκε!</span>
            `;
            document.body.appendChild(toast);

            setTimeout(() => toast.remove(), 2000);
        } catch (err) {
            console.error('Copy failed:', err);
            alert('Αντιγραφή απέτυχε. Δοκίμασε χειροκίνητα.');
        }
    });
}
