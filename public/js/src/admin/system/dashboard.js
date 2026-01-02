/**
 * Initializes the dashboard page.
 * Sets up charts and the typewriter effect if the dashboard container exists.
 */
export default function initDashboard() {
    if (!document.querySelector('.admin-analytics') && !document.querySelector('.admin-dashboard')) return;

    initCharts();
    initActions();
    initBulkDelete();
    highlightJSONBlocks();
    initSorting();
}

/**
 * Initializes all `.dashboard-chart` elements on the page.
 *
 * Parses JSON data from `data-json`, determines chart type,
 * applies styling and renders charts using Chart.js.
 */
function initCharts() {
    const dashboardCharts = document.querySelectorAll('.dash-chart');
    if (!dashboardCharts.length) return;

    // --- CSS var helpers (DaisyUI exposes HSL triples, e.g. "--p", "--er")
    const cs = getComputedStyle(document.documentElement);
    const getVar = (name) => cs.getPropertyValue(name).trim();
    const hslVar  = (name, fb) => { const v = getVar(name); return v ? `hsl(${v})` : fb; };
    const hslaVar = (name, a, fb) => { const v = getVar(name); return v ? `hsl(${v} / ${a})` : fb; };

    // --- Theme colors from DaisyUI
    const COLOR = {
        text:        hslVar('--bc', '#e5e7eb'),                 // base-content
        grid:        hslaVar('--bc', '0.15', 'rgba(229,231,235,.15)'),
        tooltipBg:   hslaVar('--n', '0.92', 'rgba(0,0,0,.92)'), // neutral surface
        tooltipBrdr: hslaVar('--bc','0.20','rgba(229,231,235,.20)'),
    };

    // --- Semantic palette (works in light & dark)
    const colorMap = {
        red:      { border: hslVar('--er', '#ef4444'), background: hslaVar('--er','0.35','rgba(239,68,68,.35)') },
        blue:     { border: hslVar('--in', '#60a5fa'), background: hslaVar('--in','0.35','rgba(96,165,250,.35)') },
        primary:  { border: hslVar('--p',  '#3b82f6'), background: hslaVar('--p','0.28','rgba(59,130,246,.28)') },
        success:  { border: hslVar('--su', '#22c55e'), background: hslaVar('--su','0.28','rgba(34,197,94,.28)') },
        warning:  { border: hslVar('--wa', '#f59e0b'), background: hslaVar('--wa','0.28','rgba(245,158,11,.28)') },
        accent:   { border: hslVar('--a',  '#a78bfa'), background: hslaVar('--a','0.28','rgba(167,139,250,.28)') },
        info:     { border: hslVar('--in', '#60a5fa'), background: hslaVar('--in','0.28','rgba(96,165,250,.28)') },
        error:    { border: hslVar('--er', '#ef4444'), background: hslaVar('--er','0.28','rgba(239,68,68,.28)') },
    };

    const borderColors     = [colorMap.red.border, colorMap.blue.border];
    const backgroundColors = [colorMap.red.background, colorMap.blue.background];

    // --- Chart.js defaults that match your UI (no hard-coded theme colors here)
    const FONT_SIZE = { axisTick: 13, legend: 14, tooltipTitle: 15, tooltipBody: 13 };

    const defaultChartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
        y: {
            beginAtZero: true,
            ticks: { color: COLOR.text, font: { size: FONT_SIZE.axisTick, weight: 'bold' }, precision: 0 },
            grid:  { color: COLOR.grid }
        },
        x: {
            ticks: { color: COLOR.text, font: { size: FONT_SIZE.axisTick }, maxRotation: 70, minRotation: 0 },
            grid:  { display: false, drawBorder: false }
        }
        },
        plugins: {
        legend:  { labels: { color: COLOR.text, font: { size: FONT_SIZE.legend } } },
        tooltip: {
            titleColor: COLOR.text, bodyColor: COLOR.text, backgroundColor: COLOR.tooltipBg,
            borderColor: COLOR.tooltipBrdr, borderWidth: 1, padding: 10,
            titleFont: { size: FONT_SIZE.tooltipTitle, weight: 'bold' },
            bodyFont:  { size: FONT_SIZE.tooltipBody }
        }
        }
    };

    dashboardCharts.forEach((canvas) => {
        const jsonDataString = canvas.dataset.json;
        const chartType = (canvas.dataset.type || 'bar').toLowerCase();
        const preferredColorKey = (canvas.dataset.color || '').toLowerCase();

        if (!jsonDataString) return;

        let chartData;
        try { chartData = JSON.parse(jsonDataString); } catch { return; }

        const datasetKeys = Object.keys(chartData);
        if (!datasetKeys.length) return;

        const labels = chartData[datasetKeys[0]].map(item => item.label);

        // Daisy-aware pie palette
        const pieColors = [
            hslaVar('--p','0.35','rgba(59,130,246,.35)'),
            hslaVar('--s','0.35','rgba(236,72,153,.35)'),
            hslaVar('--a','0.35','rgba(167,139,250,.35)'),
            hslaVar('--su','0.35','rgba(34,197,94,.35)'),
            hslaVar('--in','0.35','rgba(96,165,250,.35)'),
            hslaVar('--wa','0.35','rgba(245,158,11,.35)'),
            hslaVar('--er','0.35','rgba(239,68,68,.35)'),
        ];

        const isRadial = chartType === 'pie' || chartType === 'doughnut';

        const datasets = datasetKeys.map((key, index) => {
            const dataPoints = chartData[key].map(item => parseInt(item.cnt, 10) || 0);
            const label = key.charAt(0).toUpperCase() + key.slice(1);

            // choose color scheme
            let bg, br;
            const isSingle = datasetKeys.length === 1;
            if (isSingle && preferredColorKey && colorMap[preferredColorKey]) {
                bg = colorMap[preferredColorKey].background;
                br = colorMap[preferredColorKey].border;
            } else {
                const i = index % borderColors.length;
                bg = backgroundColors[i];
                br = borderColors[i];
            }

            const ds = {
                label,
                data: dataPoints,
                backgroundColor: isRadial ? pieColors.slice(0, dataPoints.length) : bg,
                borderColor:     isRadial ? 'transparent' : br,
                borderWidth:     isRadial ? 0 : 1.5,
            };

            if (chartType === 'line') {
                ds.fill = true;
                ds.pointBackgroundColor = br;
                ds.tension = 0.3;
            }

            return ds;
        });

        const config = { type: chartType, data: { labels, datasets }, options: { ...defaultChartOptions } };
        if (isRadial) delete config.options.scales;

        const existing = Chart.getChart(canvas);
        if (existing) existing.destroy();
        try { new Chart(canvas.getContext('2d'), config); } catch (e) { /* handle if needed */ }
    });
}

/**
 * Binds click listeners to buttons with `data-dashboard-action`.
 *
 * Triggers server-side actions via AJAX and handles loader and state.
 */
function initActions() {
    const actionButtons = document.querySelectorAll('[data-dash-action]');
    const baseUrl = document.querySelector('meta[name="base-url"]')?.content ?? '';

    if (!actionButtons.length || !baseUrl) return;

    actionButtons.forEach(button => {
        const action   = button.dataset.dashAction;
        const returnTo = button.dataset.dashReturn;

        if (!action) return;

        button.addEventListener('click', () => {
            const fetchPath = `${baseUrl}ajax/run_action/${action}`;

            // Start Animation
            const svg = button.querySelector('svg');
            button.insertAdjacentHTML('afterbegin', '<span class="loading loading-spinner size-5"></span>');
            if (svg) svg.classList.add('hidden');

            fetch(fetchPath, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(res => {
                    if (!res.ok) throw new Error(`Request failed with ${res.status}`);
                    return res.json();
                })
                .then(data => {
                    if (data.status === 'error') {
                        console.error(`Action "${action}" returned an error:`, data);
                        return;
                    }

                    if (data.status === 'redirect') {
                        window.location.href = baseUrl;
                        return;
                    }

                    if (data.status === 'Enabled' || data.status === 'Disabled') {
                        const label = button.querySelector('[data-dash-label]');
                        if (label) {
                            label.textContent = 'Cache is: ' + data.status;
                        }
                        const isEnabled = data.status === 'Enabled';
                        button.classList.toggle('btn-soft', isEnabled);
                        button.classList.toggle('btn-secondary', !isEnabled);
                        return;
                    }

                    if (returnTo) {
                        window.location.href = `${baseUrl}admin/dashboard/${returnTo}`;
                    }
                })
                .catch(err => {
                    console.error(`Action "${action}" failed:`, err);
                })
                .finally(() => {
                    // Stop Animation
                    const spinner = button.querySelector('.loading-spinner');
                    if (spinner) spinner.remove();
                    if (svg) svg.classList.remove('hidden');
                    button.blur();
                });
        });
    });
}

/**
 * Initializes bulk delete functionality for multiple table groups.
 *
 * Each delete button must have `data-bulk-delete="tableName"`.
 * Each checkbox must have `data-table="tableName"` and `data-delete-id="123"`.
 *
 * When at least one checkbox is selected, the corresponding delete button
 * becomes visible. Clicking the button sends an AJAX POST request to
 * `ajax/bulk_delete` with the selected table name and record IDs.
 */
function initBulkDelete() {
    const deleteButtons = document.querySelectorAll('[data-bulk-delete]');
    const allCheckboxes = document.querySelectorAll('input[type="checkbox"][data-delete-id]');

    if (!deleteButtons.length || !allCheckboxes.length) return;

    deleteButtons.forEach(deleteButton => {
        const table = deleteButton.dataset.bulkDelete;
        const checkboxes = Array.from(allCheckboxes).filter(cb => cb.dataset.table === table);
        if (!checkboxes.length) return;

        const updateButtonVisibility = () => {
            const anyChecked = checkboxes.some(cb => cb.checked);
            deleteButton.classList.toggle('hidden', !anyChecked);
        };

        updateButtonVisibility();
        checkboxes.forEach(cb => cb.addEventListener('change', updateButtonVisibility));

        deleteButton.addEventListener('click', () => {
            const selected = checkboxes
                .filter(cb => cb.checked)
                .map(cb => cb.dataset.deleteId);

            if (!selected.length) return;

            const payload = { table, ids: selected };
            const baseUrl = document.querySelector('meta[name="base-url"]')?.content ?? '';

            fetch(`${baseUrl}ajax/bulk_delete`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(payload)
            })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        window.location.reload();
                    } else {
                        console.error('Bulk delete error:', data);
                        alert(data.message || 'Bulk delete failed.');
                    }
                })
                .catch(err => console.error('Bulk delete failed:', err));
        });
    });
}

/**
 * Highlights JSON blocks marked with data-js-highlight="json"
 * using Tailwind & DaisyUI colors. No external dependencies.
 */
function highlightJSONBlocks() {
    document.querySelectorAll('[data-js-highlight="json"]').forEach(pre => {
        let json = pre.textContent.trim();

        // Escape HTML entities
        json = json
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');

        // Syntax highlight
        json = json.replace(
            /("(\\u[a-fA-F0-9]{4}|\\[^u]|[^"\\])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d+)?(?:[eE][+\-]?\d+)?)/g,
            match => {
                let cls = 'text-base-content';
                if (/^"/.test(match)) {
                    cls = /:$/.test(match)
                        ? 'text-primary font-semibold' // key
                        : 'text-accent';              // string value
                } else if (/true|false/.test(match)) {
                    cls = 'text-info';                // booleans
                } else if (/null/.test(match)) {
                    cls = 'text-neutral';             // null
                } else if (/^-?\d/.test(match)) {
                    cls = 'text-warning';             // numbers
                }
                return `<span class="${cls}">${match}</span>`;
            }
        );

        pre.innerHTML = json;
    });
}

/**
 * Enables drag-and-drop sorting for any list marked with [data-sortable-list].
 *
 * Expects:
 * - a container with [data-sortable-list="table_name"]
 * - children with [data-sortable-item] and data-id attributes
 *
 * Automatically calls saveOrder(table, order) after reordering.
 *
 * @returns {void}
 */
function initSorting() {
    const lists = document.querySelectorAll('[data-sortable-list]');
    if (!lists.length) return;

    lists.forEach(list => {
        const table = list.dataset.sortableList; // e.g., 'pages', 'topics', 'sections'
        let draggedItem = null;

        list.addEventListener('dragstart', event => {
            const li = event.target.closest('[data-sortable-item]');
            if (!li) return;

            draggedItem = li;
            li.classList.add('opacity-50', 'border-primary');
            event.dataTransfer.effectAllowed = 'move';
            event.dataTransfer.setData('text/plain', li.dataset.id || '');
        });

        list.addEventListener('dragover', event => {
            event.preventDefault();

            if (!draggedItem) return;

            const target = event.target.closest('[data-sortable-item]');
            if (!target || target === draggedItem) return;

            const rect = target.getBoundingClientRect();
            const offset = event.clientY - rect.top;

            if (offset < rect.height / 2) {
                list.insertBefore(draggedItem, target);
            } else {
                list.insertBefore(draggedItem, target.nextSibling);
            }
        });

        list.addEventListener('drop', event => {
            event.preventDefault();
        });

        list.addEventListener('dragend', () => {
            if (!draggedItem) return;

            draggedItem.classList.remove('opacity-50', 'border-primary');
            draggedItem = null;

            const newOrder = Array.from(list.querySelectorAll('[data-sortable-item]'))
                .map(item => item.dataset.id);

            saveOrder(table, newOrder);
        });
    });
}

/**
 * Sends the new order to the server via AJAX.
 *
 * @param {string} table - The table name ('pages', 'topics', 'sections').
 * @param {string[]} order - Array of item IDs in the new order.
 * @returns {Promise<void>}
 */
async function saveOrder(table, order) {
    const baseUrl = document.querySelector('meta[name="base-url"]')?.content;
    if (!baseUrl) return;

    try {
        const response = await fetch(`${baseUrl}ajax/update_order`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: JSON.stringify({ table, order }),
        });

        if (!response.ok) throw new Error(`HTTP ${response.status}`);

        const result = await response.json();
        console.log(`✅ ${table} order updated:`, result);
    } catch (err) {
        console.error(`❌ Error updating ${table} order:`, err);
    }
}
