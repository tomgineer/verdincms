import { getMainEditor } from './ckEditor.js';

export default function initEditContent() {
    const adminEditPage = document.querySelector('.admin-edit');
    if ( !adminEditPage ) return;
    initTextareas();
    initPostPhoto();
    initPhotoUploadTrigger();
    initSaveContent();
    initActions();
    enableDisableActions();
}

/**
 * Initialize auto-growing textareas with live char-count badges.
 *
 * Scans `.indicator textarea`, finds the nearest `.indicator-item[data-indicator]`,
 * updates the badge text (`count/limit`) and toggles daisyUI badge classes
 * (`badge-neutral`, `badge-warning`, `badge-success`, `badge-primary`) based on progress.
 * If `data-autogrow` is present (and not "false"), the textarea height expands to fit content.
 */
function initTextareas() {
  document.querySelectorAll('.indicator textarea').forEach(textarea => {
    const wrapper = textarea.closest('.indicator');
    if (!wrapper) return;

    const badge = wrapper.querySelector('.indicator-item[data-indicator]');
    if (!badge) return;

    const limitAttr = badge.dataset.indicator;
    const limit = parseInt(limitAttr, 10) || 0;
    const doAutogrow = textarea.dataset.autogrow !== undefined && textarea.dataset.autogrow !== 'false';

    const refresh = () => {
        // autogrow
        if (doAutogrow) {
            textarea.style.height = 'auto';
            textarea.style.height = textarea.scrollHeight + 'px';
        }

        const count = textarea.value.length;
        badge.textContent = limit ? `${count}/${limit}` : `${count}`;

        // badge color state
        badge.classList.remove('badge-neutral', 'badge-warning', 'badge-success', 'badge-primary');
        if (!limit) {
            badge.classList.add(count ? 'badge-primary' : 'badge-neutral');
        } else if (count >= limit) {
            badge.classList.add('badge-success');
        } else if (count > 0) {
            badge.classList.add('badge-warning');
        } else {
            badge.classList.add('badge-neutral');
        }
    };

    textarea.addEventListener('input', refresh, { passive: true });
    window.addEventListener('resize', refresh, { passive: true });
    requestAnimationFrame(refresh); // initialize (handles prefilled server value)
  });
}

/**
 * Initializes the post photo preview.
 *
 * - Updates `[data-edit-photo]` background image based on `input[name="photo"]` value.
 * - Applies a default SVG background if the value is empty.
 */
function initPostPhoto() {
    const baseUrl = document.querySelector('meta[name="base-url"]')?.content;
    const input = document.querySelector('input[name="photo"]');
    const photoContainer = document.querySelector('[data-edit-photo]');

    if (!baseUrl || !input || !photoContainer) return;

    const photosPath = baseUrl + 'images/tn/';
    const fallbackImage = `url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" stroke-opacity="0.1" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" /></svg>')`;

    const updatePhoto = () => {
        const filename = input.value.trim();
        if (!filename) {
            photoContainer.style.backgroundImage = fallbackImage;
            return;
        }

        fetch(baseUrl + 'ajax/checkPhotoExists', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ filename })
        })
        .then(response => {
            if (!response.ok) throw new Error('Request failed');
            return response.json();
        })
        .then(data => {
            if (data.photoExists) {
                const imageUrl = `${photosPath}${filename}.webp`;
                photoContainer.style.backgroundImage = `url("${imageUrl}")`;
            } else {
                photoContainer.style.backgroundImage = fallbackImage;
            }
        })
        .catch(() => {
            photoContainer.style.backgroundImage = fallbackImage;
        });
    };

    // Initial update
    updatePhoto();

    // Update on input change
    input.addEventListener('input', updatePhoto);
}

/**
 * Initializes the photo upload functionality on the `[data-edit-photo]` container.
 *
 * - Allows file selection via click or drag-and-drop.
 * - Uploads the image to the server via AJAX.
 * - On success, sets the uploaded filename into a hidden input
 *   and updates the background image using the final 1024x1024 version.
 */
function initPhotoUploadTrigger() {
    const baseUrl = document.querySelector('meta[name="base-url"]')?.content;
    const photoContainer = document.querySelector('[data-edit-photo]');
    const fileInput = photoContainer?.querySelector('#photoInput');
    const photoInput = document.querySelector('input[name="photo"]');
    const spinner = photoContainer?.querySelector('[data-edit-photo-spinner]');

    if (!photoContainer || !fileInput || !photoInput || !baseUrl) return;

    const type = photoContainer.dataset.type;

    // Spinner helper function
    const setLoading = (isLoading) => {
        if (!spinner) return;
        if (isLoading) spinner.classList.remove('hidden');
        else spinner.classList.add('hidden');
    };

    const handleFile = (file) => {
        if (file && file.type.startsWith('image/')) {
            const formData = new FormData();
            formData.append('file', file);
            formData.append('type', type);

            setLoading(true);

            fetch(baseUrl + 'ajax/uploadContentPhoto', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => res.json())
            .then(data => {
                // console.log('Upload response:', data);
                if (data.success) {
                    // Save filename
                    photoInput.value = data.filename;

                    // Show uploaded full-size image as background
                    const imageUrl = baseUrl + 'images/tn/' + data.filename + '.webp';
                    photoContainer.style.backgroundImage = `url("${imageUrl}")`;
                } else {
                    console.error('Upload failed:', data.message || data);
                }
            })
            .catch(err => console.error('Upload error:', err))
            .finally(() => setLoading(false)); // Hide spinner
        }
    };

    // Click to open dialog
    photoContainer.addEventListener('click', () => {
        fileInput.click();
    });

    // File selected via input
    fileInput.addEventListener('change', () => {
        handleFile(fileInput.files[0]);
        fileInput.value = '';
    });

    // Drag over
    photoContainer.addEventListener('dragover', (e) => {
        e.preventDefault();
        photoContainer.classList.add('drag-over');
    });

    // Drag leave
    photoContainer.addEventListener('dragleave', () => {
        photoContainer.classList.remove('drag-over');
    });

    // Drop file
    photoContainer.addEventListener('drop', (e) => {
        e.preventDefault();
        photoContainer.classList.remove('drag-over');

        const file = e.dataTransfer.files[0];
        handleFile(file);
    });
}

/**
 * Collects form data and sends it to the server to save a post.
 *
 * - Syncs CKEditor content into the hidden `input[name="body"]`.
 * - Gathers values from inputs, checkboxes, selects, textareas, and hidden fields.
 * - Sends the data as JSON to `ajax/saveContent` via POST.
 * - Animates the triggering button by adding the `.animate` class and removing it after 650ms.
 *
 * @param {HTMLElement} saveButton - The button that triggered the save (used for animation feedback).
 */
function saveContentData(saveButton) {
    if (!saveButton) return;

    const baseUrl = document.querySelector('meta[name="base-url"]')?.content;
    if (!baseUrl) return;

    const saveToast = document.querySelector('[data-toast-save]');

    // Sync CKEditor content to hidden inputs
    const editor         = getMainEditor();
    const bodyInput      = document.querySelector('input[name="body"]');
    const highlightInput = document.querySelector('input[name="highlight"]');
    const idInput        = document.querySelector('input[name="id"]');

    if (editor && bodyInput) {
        const html = editor.getData();
        bodyInput.value = html;

        if (highlightInput) {
            // Normalize and check for any <pre> tags
            const hasPreTag = /<pre[\s>]/i.test(html);
            highlightInput.value = hasPreTag ? '1' : '0';
        }
    }

    // Collect all fields
    const fields = document.querySelectorAll(
        'input[type="text"][name], input[type="checkbox"][name], input[type="hidden"][name], select[name], textarea[name]'
    );

    const data = {};

    fields.forEach(field => {
        const name = field.name;
        data[name] = field.type === 'checkbox' ? (field.checked ? '1' : '0') : field.value;
    });

    // Add data-type from button to data object
    const type = document.querySelector('[data-action="save-content"]').dataset.type;
    if (type) {
        data.type = type;
    }

    // Send to server
    fetch(baseUrl + 'ajax/saveContent', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(response => {
        if (response.success) {

            // Refresh
            if (idInput && response.id && idInput.value === '0') {
                window.location.href = `${baseUrl}admin/edit/${data.type}/${response.id}`;
                return;
            }

            saveToast.classList.remove('hidden');
            enableDisableActions();
            setTimeout(() => {saveToast.classList.add('hidden');}, 1500);
        } else {
            console.error('Save failed:', response.message || response);
        }
    })
    .catch(error => {
        console.error('Save error:', error);
    });
}

/**
 * Initializes the main save button for content editing.
 *
 * - Listens for clicks on the `[data-action="save-content"]` button.
 * - Calls `saveContentData()` with the button reference.
 */
function initSaveContent() {
    const saveButton = document.querySelector('[data-action="save-content"]');
    if (!saveButton) return;

    saveButton.addEventListener('click', () => saveContentData(saveButton));
}

/**
 * Initializes post action controls for the editor interface.
 *
 * Handles:
 * - Updating the post status (Published, Draft, Deleted) and badge color.
 * - Resetting the post creation date to the current timestamp.
 * - Inlining or clearing the post photo.
 *
 * Dependencies:
 * - Expects a [data-edit-menu] container with buttons:
 *   [data-action="publish"], [data-action="unpublish"], [data-action="delete"],
 *   [data-action="reset-date"], [data-action="inline-photo"], [data-action="clear-photo"].
 * - Requires hidden inputs: name="status", name="created", name="photo".
 * - Expects a badge element inside [data-info="status"] for visual feedback.
 * - Uses DaisyUI classes: badge-success | badge-warning | badge-error.
 *
 * @function initActions
 * @returns {void}
 */
function initActions() {
    const actionsContainer = document.querySelector('[data-edit-menu]');
    if (!actionsContainer) return;

    // Inputs & Info Displays
    const inputStatus      = document.querySelector('input[name="status"]');
    const infoStatus       = document.querySelector('[data-info="status"] .badge'); // badge span
    const inputCreated     = document.querySelector('input[name="created"]');
    const infoCreated      = document.querySelector('[data-info="created"]');
    const inputPhoto       = document.querySelector('input[name="photo"]');
    const photoContainer   = document.querySelector('[data-edit-photo]');

    // Actions
    const actionPublish     = actionsContainer.querySelector('[data-action="publish"]');
    const actionUnpublish   = actionsContainer.querySelector('[data-action="unpublish"]');
    const actionDelete      = actionsContainer.querySelector('[data-action="delete"]');
    const actionResetDate   = actionsContainer.querySelector('[data-action="reset-date"]');
    const actionInlinePhoto = actionsContainer.querySelector('[data-action="inline-photo"]');
    const actionClearPhoto  = actionsContainer.querySelector('[data-action="clear-photo"]');

    /**
     * Updates post status and badge tone.
     * @param {HTMLElement} button - Button element triggering the change.
     * @param {number} value - Numeric status code (1=Published, 2=Draft, 3=Deleted).
     * @param {string} label - Human-readable label.
     * @param {'success'|'warning'|'error'} tone - Badge tone class.
     */
    const setStatus = (button, value, label, tone) => {
        inputStatus.value = value;
        saveContentData(button);

        if (infoStatus) {
            infoStatus.textContent = label;
            infoStatus.classList.remove('badge-success', 'badge-warning', 'badge-error');
            infoStatus.classList.add('badge-' + tone);
        }
    };

    /**
     * Resets the creation date field to the current timestamp.
     * @param {HTMLElement} button - The button that triggered the action.
     */
    const resetDate = (button) => {
        const now = new Date();
        const pad = n => String(n).padStart(2, '0');

        const formatted = [
            now.getFullYear(),
            pad(now.getMonth() + 1),
            pad(now.getDate())
        ].join('-') + ' ' + [
            pad(now.getHours()),
            pad(now.getMinutes()),
            pad(now.getSeconds())
        ].join(':');

        inputCreated.value = formatted;

        const display = now.toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });

        infoCreated.textContent = display;
        saveContentData(button);
    };

    /**
     * Clears the post photo and restores the fallback image.
     */
    const clearPhoto = () => {
        inputPhoto.value = '';
        const fallbackImage = `url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" stroke-opacity="0.1" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" /></svg>')`;
        photoContainer.style.backgroundImage = fallbackImage;
    };

    // Listeners
    actionPublish.addEventListener('click', e => {
        setStatus(e.currentTarget, 1, 'Published', 'success');
    });

    actionUnpublish.addEventListener('click', e => {
        setStatus(e.currentTarget, 2, 'Draft', 'warning');
    });

    actionDelete.addEventListener('click', e => {
        setStatus(e.currentTarget, 3, 'Deleted', 'error');
    });

    actionResetDate.addEventListener('click', e => {
        resetDate(e.currentTarget);
    });

    actionInlinePhoto.addEventListener('click', e => {
        inlinePicture(e.currentTarget);
    });

    actionClearPhoto.addEventListener('click', e => {
        clearPhoto();
    });
}

/**
 * Handles inline image upload and insertion into the main CKEditor instance.
 *
 * Opens a hidden file input, uploads the selected image via AJAX to the server,
 * and inserts it as a block-level image into the editor at the current cursor position.
 * Adds a loading animation class to the triggering button during the upload.
 *
 * @param {HTMLElement} button - The button element that triggered the upload action.
 */
function inlinePicture(button) {
    const baseUrl = document.querySelector('meta[name="base-url"]')?.content;
    const inputInlinePhoto = document.querySelector('#inlinePhotoInput');
    const mainEditor = getMainEditor();
    if (!baseUrl || !inputInlinePhoto || !mainEditor) return;

    inputInlinePhoto.onchange = () => {
        const file = inputInlinePhoto.files[0];
        if (!file) {
            inputInlinePhoto.value = '';
            return;
        }

        if (!file.type.startsWith('image/')) {
            console.warn('Selected file is not an image:', file.name);
            inputInlinePhoto.value = '';
            return;
        }

        // Hide the icon (SVG) and show spinner
        const icon = button.querySelector('svg');
        if (icon) icon.classList.add('hidden');

        const spinner = document.createElement('span');
        spinner.className = 'loading loading-spinner';
        button.prepend(spinner);

        // Disable the button while uploading
        button.classList.add('btn-disabled');

        const formData = new FormData();
        formData.append('file', file);

        fetch(baseUrl + 'ajax/uploadInlinePhoto', {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success && data.url) {
                mainEditor.model.change(writer => {
                    const imageElement = writer.createElement('imageBlock', {
                        src: data.url,
                        alt: data.filename,
                        loading: 'lazy'
                    });

                    const selection = mainEditor.model.document.selection;
                    const insertPosition = selection.getFirstPosition();
                    const currentBlock = insertPosition.parent;

                    writer.insert(imageElement, writer.createPositionBefore(currentBlock));
                    writer.remove(currentBlock);
                });
            } else {
                console.error('Upload failed:', data.error || data.message || 'Unknown error');
            }
        })
        .catch(err => console.error('Upload error:', err))
        .finally(() => {
            // Remove spinner, show icon again, re-enable button
            spinner.remove();
            if (icon) icon.classList.remove('hidden');
            button.classList.remove('btn-disabled');
            inputInlinePhoto.value = '';
        });
    };

    // Open file picker
    inputInlinePhoto.click();
}


/**
 * Toggles action button states based on item status.
 * Disables specific buttons in `.edit-actions` depending on:
 * - '0' (New): disables all
 * - '1' (Published): disables Publish
 * - '2' (Draft): disables Unpublish
 * - '3' (Deleted): disables Delete + Unpublish
 * Runs on load and on `status` input change.
 */
function enableDisableActions() {
    const actionsContainer = document.querySelector('[data-edit-menu]');
    if (!actionsContainer) return;

    // Inputs
    const idInput     = document.querySelector('input[name="id"]');
    const statusInput = document.querySelector('input[name="status"]');
    if (!idInput || !statusInput) return;

    // Actions
    const actionPreview   = actionsContainer.querySelector('[data-action="preview"]');
    const actionPublish   = actionsContainer.querySelector('[data-action="publish"]');
    const actionUnpublish = actionsContainer.querySelector('[data-action="unpublish"]');
    const actionDelete    = actionsContainer.querySelector('[data-action="delete"]');
    const actionResetDate = actionsContainer.querySelector('[data-action="reset-date"]');

    if (!actionPreview || !actionPublish || !actionUnpublish || !actionDelete || !actionResetDate) {
        return;
    }

    const getRealStatus = () => idInput.value === '0' ? '0' : statusInput.value;

    const handleValueChange = (value) => {
        const all = [actionPreview, actionPublish, actionUnpublish, actionDelete, actionResetDate];
        const hideMap = {
            '0': all,
            '1': [actionPublish],
            '2': [actionUnpublish],
            '3': [actionDelete, actionUnpublish],
        };

        const hide = hideMap[value];
        if (!hide) return;

        all.forEach(el => el.classList.remove('btn-disabled'));
        hide.forEach(el => el.classList.add('btn-disabled'));
    };

    handleValueChange(getRealStatus(), true);
}