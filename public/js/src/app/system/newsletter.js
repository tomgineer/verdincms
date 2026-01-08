/**
 * Initialize newsletter subscription handling.
 *
 * Attaches an event listener to the newsletter form, validates the email,
 * and sends it to the server via AJAX for subscription.
 */
export default function newsletterInit() {
    newsletterSubscribe();
}

/**
 * Attaches submit listener to the newsletter form and handles AJAX submission.
 *
 * @private
 * @function newsletterSubscribe
 * @returns {void}
 */
function newsletterSubscribe() {
    const form = document.getElementById('newsletter-form');
    if (!form) return;

    const baseUrl = document.querySelector('meta[name="base-url"]')?.content;
    const cookieName = document.querySelector('meta[name="csrf-cookie-name"]')?.content || 'csrf_cookie_name';
    let csrfToken = getCookie(cookieName);
    if (!baseUrl) return;

    const msgEl      = document.getElementById('newsletter-message');
    const emailInput = form.querySelector('input[name="email"]');
    const hpInput    = form.querySelector('input[name="hp_newsletter"]');
    const submitBtn  = form.querySelector('button[type="submit"]');

    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        const email    = emailInput.value.trim();
        const honeypot = hpInput ? hpInput.value.trim() : '';

        if (!email) {
            if (msgEl) msgEl.textContent = 'Παρακαλώ γράψε το email σου.';
            return;
        }

        // Honeypot triggered → silently ignore
        if (honeypot !== '') {
            if (msgEl) msgEl.textContent = 'Ευχαριστούμε για την εγγραφή!';
            form.reset();
            return;
        }

        if (msgEl) msgEl.textContent = 'Γίνεται επεξεργασία...';
        if (submitBtn) submitBtn.disabled = true;

        const payload = { email };
        csrfToken = getCookie(cookieName);

        try {
            const response = await fetch(`${baseUrl}newsletter/subscribe`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken, // from CSRF cookie
                },
                body: JSON.stringify(payload),
            });

            const data = await response.json();

            if (data.success) {
                if (msgEl) {
                    msgEl.textContent = data.message || 'Ευχαριστούμε για την εγγραφή! Έλεγξε το email σου.';
                    msgEl.classList.remove('text-sm');
                    msgEl.classList.add('opacity-100', 'text-lg');
                }
                form.reset();
            } else {
                if (msgEl) {
                    msgEl.textContent = data.message || 'Κάτι πήγε στραβά. Προσπάθησε ξανά.';
                }
            }
        } catch (error) {
            console.error(error);
            if (msgEl) msgEl.textContent = 'Σφάλμα δικτύου. Δοκίμασε αργότερα.';
        } finally {
            if (submitBtn) submitBtn.disabled = false;
        }
    });
}

function getCookie(name) {
    const cookies = document.cookie ? document.cookie.split('; ') : [];
    for (const cookie of cookies) {
        if (cookie.startsWith(`${name}=`)) {
            return cookie.substring(name.length + 1);
        }
    }
    return '';
}
