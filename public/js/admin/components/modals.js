import { smallEditors } from '../system/ckEditor.js';

export default async function initModals() {
    if (!document.querySelector('dialog.modal')) return;

    if (document.querySelector('[data-target-modal]')) {
        initModifyButtons();
    }

    if (document.querySelector('input[type="file"]')) {
        uploadFiles();
    }

    if (document.querySelector('[data-save-form]')) {
        saveForm();
    }

    try {
        await autoFillSelect(); // wait until all selects are populated
    } catch (err) {
        console.error('Init modals error:', err);
    }
}

/**
 * Populates all <select> elements marked with [data-autofill-select].
 *
 * Sends an AJAX request to fetch id/column pairs for each dropdown
 * and dynamically appends the results as <option> elements.
 *
 * @async
 * @function autoFillSelect
 * @returns {Promise<void>} Resolves when all dropdown requests have been triggered
 */
async function autoFillSelect() {
    const dropdowns = document.querySelectorAll('[data-autofill-select]');
    const baseUrl = document.querySelector('meta[name="base-url"]')?.content || '/';

    // create a promise for each dropdown
    const tasks = Array.from(dropdowns).map(async dropdown => {
        const table = dropdown.dataset.table;
        const column = dropdown.dataset.column;

        try {
            const response = await fetch(`${baseUrl}ajax/modalFillSelect`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ table, column })
            });

            if (!response.ok) throw new Error(`HTTP ${response.status}`);

            const data = await response.json();

            // Clear current options
            dropdown.innerHTML = '';

            // Add options
            data.forEach(row => {
                const opt = document.createElement('option');
                opt.value = row.id;
                opt.textContent = row[column];
                dropdown.appendChild(opt);
            });

        } catch (err) {
            console.error('Error filling select:', err);
        }
    });

    // wait until all selects are done
    return Promise.all(tasks);
}

/**
 * Fetches a database record for a single section marked with [data-autofill-form]
 * and fills its inputs with the returned values.
 *
 * autoFillForm(section) → Handles AJAX fetch from the server for ONE form section.
 * fillControls(section, data) → Populates form fields based on the response data.
 *
 * @param {HTMLElement} formSection - The element that has data-autofill-form
 */
async function autoFillForm(formSection) {
    if (!formSection) return;

    const baseUrl = document.querySelector('meta[name="base-url"]')?.content || '/';

    const table   = formSection.dataset.autofillForm;
    const idInput = formSection.querySelector('[name="id"]');

    if (!idInput || !idInput.value) return; // nothing to load

    try {
        const response = await fetch(`${baseUrl}ajax/modalFillForm`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                id: idInput.value,
                table: table
            })
        });

        if (!response.ok) {
            throw new Error(`HTTP ${response.status}`);
        }

        const data = await response.json();
        fillControls(formSection, data);

    } catch (err) {
        console.error('AutoFill error:', err);
    }
}

function fillControls(form, data) {
    if (!form || !data) return;

    // loop through the data object
    Object.entries(data).forEach(([name, value]) => {
        // find all controls in the form with this name
        const field = form.querySelector(`[name="${name}"]`);
        if (!field) return;

        // By Type
        if (field.type) {
            switch (field.type) {
                case 'text':
                case 'email':
                case 'number':
                    field.value = value;
                    break;
                case 'password':
                    field.value = '';
                    break;
                case 'checkbox':
                    field.checked = (value == 1);
                    break;
                case 'date':
                    field.value = value ? value.split(' ')[0] : '';
                    break;
                default:
                    break;
            }
        }

        // By Tag Name
        switch (field.tagName) {
            case 'SELECT':
                field.value = value;
                break;
            case 'TEXTAREA':
                field.classList.contains('simple-editor')
                    ? smallEditors[name].setData(value)
                    : (field.value = value);
                break;
            default:
                break;
        }
    });

    // Reset all file uploaders
    form.querySelectorAll('input[type="file"]').forEach(input => {
        input.value = '';
    });

}

/**
 * Initializes save button handlers in all modals and submits form data via AJAX.
 *
 * - Finds all buttons with the [data-save-form] attribute inside .modal elements.
 * - Extracts the target table from the modal's [data-autofill-form] attribute.
 * - On click, gathers form data using getDataFromForm(modal).
 * - Sends a POST request to the server with the table name and form data.
 *
 * Requires:
 * - `getDataFromForm(modal)` function to extract form values.
 * - A <meta name="base-url"> tag in the HTML head.
 */
async function saveForm() {
    const saveButtons = document.querySelectorAll('.modal [data-save-form]');
    if (!saveButtons.length) return;

    const baseUrl = document.querySelector('meta[name="base-url"]')?.content || '/';

    saveButtons.forEach(button => {
        const modal = button.closest('.modal');
        if (!modal) return;

        const formSection = modal.querySelector('[data-autofill-form]');
        if (!formSection) return;

        const table = formSection.dataset.autofillForm;
        if (!table) return;

        button.addEventListener('click', async e => {
            const data = getDataFromForm(modal);
                console.log(data);
            try {
                const response = await fetch(`${baseUrl}ajax/modalSaveForm`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ table, data })
                });

                if (!response.ok) {
                    console.error(`Server responded with status ${response.status}`);
                } else {
                    const result = await response.json();

                    if (result.success) {
                        modal.close();
                        window.location.reload();
                    } else {
                        console.error(result.message || 'Save failed');
                    }
                }
            } catch (err) {
                console.error('Fetch error:', err);
            }
        });
    });
}

/**
 * Extracts form data from a modal element into a plain object.
 *
 * - Selects all form fields within the modal that have a [name] attribute.
 * - Handles specific field types (`text`, `file`) and elements (`SELECT`, `TEXTAREA`).
 * - For textareas with the `simple-editor` class, uses the corresponding smallEditor instance.
 *
 * @param {HTMLElement} modal - The modal element containing the form fields.
 * @returns {Object} data - An object mapping field names to their corresponding values.
 */
function getDataFromForm(modal) {
    const data = {};

    modal.querySelectorAll('[name]').forEach(field => {
        const name = field.name;

        // By Type
        if (field.type) {
            switch (field.type) {
                case 'text':
                case 'email':
                case 'password':
                case 'number':
                case 'date':
                    data[name] = field.value;
                    break;
                case 'checkbox':
                    data[name] = field.checked ? 1 : 0;
                    break;
                default:
                    break;
            }
        }

        // By Tag Name
        switch (field.tagName) {
            case 'SELECT':
                data[name] = field.value;
                break;
            case 'TEXTAREA':
                data[name] = field.classList.contains('simple-editor')
                    ? smallEditors[name].getData()
                    : field.value;
                break;
            default:
                break;
        }
    });

    return data;
}

/**
 * Initializes file input listeners for AJAX file uploads.
 *
 * On file selection, the function reads custom data attributes from the input,
 * sends the file and related info via POST to the modalUploadFile endpoint,
 * and updates the corresponding readonly input with the uploaded filename.
 *
 * Requirements:
 * - <meta name="base-url"> must exist in the document head.
 * - File inputs must include `data-path` (upload path) and `data-input` (linked input name).
 */
async function uploadFiles() {
    const baseUrl = document.querySelector('meta[name="base-url"]')?.content || '/';

    document.querySelectorAll('input[type="file"]').forEach(input => {
        input.addEventListener('change', async function () {
            if (this.files.length === 0) return;

            const modal = this.closest('.modal');
            if (!modal) return;

            const file = this.files[0];
            const path = this.dataset.path;
            const linkedInputName = this.dataset.input;

            const formData = new FormData();
            formData.append('file', file);
            formData.append('path', path);
            formData.append('field', linkedInputName); // so backend knows where to return

            // Find and disable the closest save button
            const saveButton = modal.querySelector('[data-save-form]');
            if (saveButton) saveButton.setAttribute('disabled', 'disabled');

            try {
                const response = await fetch(`${baseUrl}ajax/modalUploadFile`, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: formData
                });

                const data = await response.json();

                if (response.ok && data.status === 'success') {
                    modal.querySelector(`input[name="${linkedInputName}"]`).value = data.filename;
                } else {
                    alert(data.message || 'Upload failed');
                }

            } catch (error) {
                console.error('Upload error:', error);
                alert('An error occurred while uploading.');
            } finally {
                // Re-enable the save button after upload
                if (saveButton) saveButton.removeAttribute('disabled');
            }
        });
    });
}

/**
 * Initializes delegated click handling for modify buttons and manages modal behavior.
 *
 * - Listens for clicks on any element with [data-target-modal][data-modify-id].
 * - Opens the target <dialog> modal by ID.
 * - For "new" (data-modify-id="new"):
 *      - Resets the modal form and leaves id empty (create mode).
 * - For existing ids:
 *      - Sets input[name="id"] inside [data-autofill-form]
 *      - Calls autoFillForm() to fetch and fill the form.
 * - Adds the .scrollbar-auto class to <html> when a modal opens,
 *   and removes it when the modal closes.
 */
function initModifyButtons() {
    document.addEventListener('click', function (e) {
        const button = e.target.closest('[data-target-modal][data-modify-id]');
        if (!button) return; // not a modify button

        const modalId  = button.dataset.targetModal;
        const modifyId = button.dataset.modifyId; // 'new' or an id like '5'

        const modal = document.getElementById(modalId);
        if (!modal) return;

        const formSection = modal.querySelector('[data-autofill-form]');
        if (!formSection) {
            console.error('No [data-autofill-form] inside modal', modalId);
            return;
        }

        const idInput = formSection.querySelector('input[name="id"]');
        if (!idInput) {
            console.error('No [name="id"] inside [data-autofill-form] in modal', modalId);
            return;
        }

        if (modifyId === 'new') {
            resetModalForm(modal);
            idInput.value = 'new'; // keep empty -> autoFillForm will do nothing
        } else {
            resetModalForm(modal); // clear stale data
            idInput.value = modifyId;

            // Explicitly fill only this form section
            autoFillForm(formSection);
        }

        document.documentElement.classList.add('scrollbar-auto');
        modal.showModal();
    });

    // Remove .scrollbar-auto from modal when closing
    document.addEventListener('close', function (e) {
        if (e.target.matches('dialog.modal')) {
            document.documentElement.classList.remove('scrollbar-auto');
        }
    }, true);
}

/**
 * Resets all fields inside the [data-autofill-form] container of a modal.
 * Generic for all modals.
 *
 * - Clears text inputs, textareas, selects.
 * - Unchecks checkboxes.
 * - For fields with data-default, uses that value instead of empty.
 * - For simple-editor textareas, clears via smallEditors.
 */
function resetModalForm(modal) {
    if (!modal) return;

    const container = modal.querySelector('[data-autofill-form]');
    if (!container) return;

    container.querySelectorAll('input[name], textarea[name], select[name]').forEach(field => {
        const name = field.name;

        // Textareas with simple-editor
        if (field.tagName === 'TEXTAREA' && field.classList.contains('simple-editor')) {
            if (smallEditors[name]) {
                smallEditors[name].setData('');
            } else {
                field.value = '';
            }
            return;
        }

        // Checkboxes → unchecked
        if (field.type === 'checkbox') {
            field.checked = false;
            return;
        }

        // Password fields → placeholder + required
        if (field.type === 'password') {
            field.value = '';
            field.placeholder = 'Password';
            field.required = true;
            return;
        }

        // Everything else: reset to empty, then apply data-default if present
        let defaultValue = '';

        if (field.dataset.default !== undefined) {
            defaultValue = field.dataset.default;
        }

        field.value = defaultValue;
    });
}
