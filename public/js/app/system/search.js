/**
 * Initializes the search input listener with debounce functionality.
 *
 * Listens for user input in the search field and triggers the search
 * request after a short delay to avoid excessive requests. If the
 * input is cleared, the current search results are reset.
 *
 * @function initSearch
 * @returns {void}
 */
export default function initSearch() {
    const searchInput = document.querySelector('[data-js-search]');
    if (!searchInput) return;

    let debounceTimer;

    searchInput.addEventListener('input', () => {
        const rawQuery = searchInput.value;
        const query = rawQuery.trim();

        if (!query) {
            clearTimeout(debounceTimer);
            hideSearchResults();
            return;
        }

        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            displaySearchResults(query);
        }, 300); // tweak delay as you like
    });
}

/**
 * Hides the search results panel and clears its content.
 */
function hideSearchResults() {
    const target = document.querySelector('[data-js-search-results]');
    if (!target) return;

    target.classList.add('hidden');
    target.innerHTML = '';
}

/**
 * Fetches search results from the backend and displays them in the UI.
 *
 * Sends an AJAX request to the server with the given query, handles
 * response and error states, and updates the search results container.
 *
 * @async
 * @function displaySearchResults
 * @param {string} query - The search term entered by the user.
 * @returns {Promise<void>}
 */
async function displaySearchResults(query) {
    const baseUrl = document.querySelector('meta[name="base-url"]')?.content;
    if (!baseUrl) return;

    const target = document.querySelector('[data-js-search-results]');
    if (!target) return;

    // Show a loading indicator while fetching
    target.classList.remove('hidden');

    target.innerHTML = `<span class="loading loading-ring loading-xl text-secondary"></span>`;

    try {
        const response = await fetch(
            `${baseUrl}ajax/search?q=${encodeURIComponent(query)}`,
            {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            }
        );

        if (!response.ok) {
            const text = await response.text();
            console.error('Fetch error:', text);
            throw new Error(`HTTP ${response.status}`);
        }

        // Parse response
        const results = await response.json();

        const html = buildSearchResultsHtml(results, query, baseUrl);
        target.innerHTML = html;

    } catch (err) {
        console.error('Error fetching search results:', err);
        target.innerHTML = `
            <p class="text-error">Failed to load search results.</p>
        `;
    }
}

/**
 * Builds the HTML markup for displaying search results.
 *
 * Generates a responsive list of post cards matching the given query.
 * Escapes all text fields for safety and creates full URLs using the base path.
 *
 * @param {Array<Object>} results - Array of post objects returned by the backend.
 * @param {string} query - The user’s search term.
 * @param {string} baseUrl - The base URL used to build internal links.
 * @returns {string} HTML string representing the rendered search results section.
 */
function buildSearchResultsHtml(results, query, baseUrl) {
    const safeQuery = escapeHtml(query ?? '');

    if (!Array.isArray(results) || results.length === 0) {
        return `
            <div class="p-8 text-center text-base-content/60">
                Δεν βρέθηκαν αποτελέσματα για "<strong>${safeQuery}</strong>"
            </div>
        `;
    }

    const itemsHtml = results.map(post => {
        const id           = post.id;
        const title        = escapeHtml(post.title ?? '');
        const subtitle     = escapeHtml(post.subtitle ?? '');
        const author       = escapeHtml(post.author ?? '');
        const authorHandle = escapeHtml(post.author_handle ?? '');
        const topic        = escapeHtml(post.topic ?? '');
        const topicSlug    = escapeHtml(post.topic_slug ?? '');
        const ago          = escapeHtml(post.ago ?? '');

        const postUrl   = `${baseUrl}post/${id}`;
        const authorUrl = `${baseUrl}author/${authorHandle}`;
        const topicUrl  = `${baseUrl}topic/${topicSlug}`;

        return `
            <li class="flex flex-col">
                <div class="card bg-base-200 card-md flex-1">
                    <div class="card-body">
                        <a class="mb-1 hover:underline" href="${postUrl}">
                            <h2 class="card-title font-medium">${title}</h2>
                        </a>
                        <p>${subtitle}</p>
                        <div class="card-actions justify-end">
                            <a class="text-secondary hover:underline" href="${authorUrl}">${author}</a>
                            <span class="text-base-content/50">/ ${ago} ${escapeHtml(window.miscIn ?? 'in')}</span>
                            <a class="text-secondary hover:underline" href="${topicUrl}">${topic}</a>
                        </div>
                    </div>
                </div>
            </li>
        `;
    }).join('');

    return `
        <section class="flex flex-col gap-4">
            <ul class="contents">
                ${itemsHtml}
            </ul>
        </section>
    `;
}

/**
 * Escapes HTML special characters in a string to prevent injection.
 *
 * @function escapeHtml
 * @param {string} str - The string to escape.
 * @returns {string} The escaped string safe for HTML insertion.
 */
function escapeHtml(str) {
    if (typeof str !== 'string') return '';
    return str
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}
