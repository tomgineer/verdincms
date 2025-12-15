export let mainEditor = null;
export const smallEditors = {}; // Store multiple editors by their `name`

/**
 * Returns the main BalloonEditor instance.
 *
 * @returns {BalloonEditor|null} The main editor instance or null if not initialized.
 */
export function getMainEditor() {
	return mainEditor;
}

/**
 * Returns a simple ClassicEditor instance by field name.
 *
 * @param {string} name
 * @returns {ClassicEditor|null}
 */
export function getSmallEditor(name) {
    return smallEditors[name] ?? null;
}

/**
 * Initializes CKEditor 5 ClassicEditor on all `.simple-editor` elements.
 *
 * Features:
 * - Minimal toolbar: heading, bold, italic, link, lists, undo/redo
 * - External link decorator for opening in new tab
 *
 * Stores the editor instances globally in `smallEditor`.
 */
export function initSimpleEditor() {
    // Only pick editors that are not initialized yet
    const simpleEditor = document.querySelectorAll('.simple-editor:not([data-editor-initialized])');
    if (!simpleEditor.length) return;

    simpleEditor.forEach(editor => {
        const name = editor.getAttribute('name');
        if (!name) {
            console.warn('Simple editor is missing a name attribute:', editor);
            return;
        }

        // If we already have an editor for this name, skip
        if (smallEditors[name]) {
            return;
        }

        ClassicEditor
            .create(editor, {
                toolbar: {
                    items: [ 'heading', '|', 'bold', 'italic', 'link',  '|', 'bulletedList', 'numberedList', '|', 'undo', 'redo'],
                    shouldNotGroupWhenFull: true
                },
                link: {
                    decorators: {
                        addTargetToExternalLinks: {
                            mode: 'manual',
                            label: 'Open in a new tab',
                            attributes: { target: '_blank', rel: 'nofollow' }
                        }
                    }
                }
            })
            .then(editorInstance => {
                smallEditors[name] = editorInstance; // Save editor by its name
                editor.setAttribute('data-editor-initialized', '1');
            })
            .catch(error => { console.error(error); });
    });
}

/**
 * Initializes CKEditor 5 BalloonEditor on `.edit-body`.
 *
 * Docs:
 * https://ckeditor.com/docs/ckeditor5/latest/builds/guides/integration/basic-api.html
 *
 * Included plugins:
 * - Bold, Italic, Blockquote, Heading, Link, List
 * - Media Embed, Table, Word Count, Remove Format
 * - HTML Embed, Indent/Outdent, Code Blocks
 *
 * Custom features:
 * - Restores content from input[name="body"]
 * - Updates word/char counters
 * - Highlights word count >= 500
 * - Custom heading styles (caption, bonus, update, etc.)
 *
 * Skips if `.edit-body` is not found.
 */
export function initBaloonEditor() {
    const contentEditor  = document.querySelector('.edit-body');
    if( !contentEditor ) return;

    const wordCount  = document.querySelector('[data-info="words"]');
    const charCount  = document.querySelector('[data-info="chars"]');
    const inputBody  = document.querySelector('input[name="body"]');
    const inputWords = document.querySelector('input[name="words"]');

    BalloonEditor
    .create( contentEditor, {
        toolbar: [ 'removeFormat', 'heading', '|', 'bold', 'italic', 'link', '|', 'bulletedList', 'numberedList', 'indent', 'outdent', '|', 'blockQuote', 'insertTable', 'htmlEmbed', 'codeblock', '|', 'undo', 'redo'],
        mediaEmbed: {
            removeProviders: [ 'instagram', 'twitter', 'googleMaps', 'flickr', 'facebook' ],
            previewsInData:true
        },
        heading: {
            options: [
            { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
            { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
            { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
            { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
            { model: 'photoCaption', view: {name: 'h6', classes: 'photo-caption'}, title: 'Photo Caption', class: 'ck-heading_heading_caption' },
            { model: 'update', view: {name: 'h4', classes: 'update'}, title: 'Update', class: 'ck-heading_heading_update' },
            { model: 'bonus', view: {name: 'h4', classes: 'bonus'}, title: 'Bonus', class: 'ck-heading_heading_bonus' },
            { model: 'smallText', view: {name: 'h6', classes: 'small-text'}, title: 'Small Text', class: 'ck-heading_heading_small_text' },
            { model: 'section', view: {name: 'h5', classes: 'section'}, title: 'Section', class: 'ck-heading_heading_section' }
            ]
        }, // heading
        link: {
            decorators: {
                addTargetToExternalLinks: {
                    mode: 'manual', label: 'Open in a new tab',
                    attributes: {target: '_blank', rel: 'nofollow'}
                }
            }
        }, // link
        wordCount: {
            onUpdate: stats => {
                // Update display elements (e.g. <span> or <div>)
                if (wordCount) wordCount.textContent = stats.words;
                if (charCount) charCount.textContent = stats.characters;

                // Update hidden input for saving
                if (inputWords) inputWords.value = stats.words;

                // Apply color class based on word count
                if (stats.words < 350) {
                    wordCount?.classList.add('badge-error');
                    wordCount?.classList.remove('badge-warning', 'badge-success');
                } else if (stats.words < 500) {
                    wordCount?.classList.add('badge-warning');
                    wordCount?.classList.remove('badge-error', 'badge-success');
                } else {
                    wordCount?.classList.add('badge-success');
                    wordCount?.classList.remove('badge-error', 'badge-warning');
                }

            }
        }, // wordCount
        codeBlock: {
            languages: [
                { language: 'css', label: 'CSS' },
                { language: 'scss', label: 'SCSS' },
                { language: 'xml', label: 'HTML' },
                { language: 'php', label: 'PHP' },
                { language: 'javascript', label: 'Javascript' },
                { language: 'json', label: 'JSON' },
                { language: 'plaintext', label: 'Plaitext' }
            ]
        }
    })
    .then( editor => {
        // Allow the 'loading' attribute on imageBlock (Loading Lazy)
        editor.model.schema.extend('imageBlock', {
            allowAttributes: ['loading']
        });

        // Downcast: render loading="lazy" on <img> inside <figure>
        editor.conversion.for('downcast').add(dispatcher => {
            dispatcher.on('attribute:loading:imageBlock', (evt, data, conversionApi) => {
                const viewWriter = conversionApi.writer;
                const figure = conversionApi.mapper.toViewElement(data.item);
                const viewImg = figure?.getChild(0); // get <img> inside <figure>
                if (!viewImg) return;

                if (data.attributeNewValue) {
                    viewWriter.setAttribute('loading', data.attributeNewValue, viewImg);
                } else {
                    viewWriter.removeAttribute('loading', viewImg);
                }
            });
        });

        // Ensure every imageBlock always gets loading="lazy"
        editor.model.document.on('change:data', () => {
            const model = editor.model;

            model.change(writer => {
                for (const element of model.document.getRoot().getChildren()) {
                    if (element.is('element', 'imageBlock') && !element.getAttribute('loading')) {
                        writer.setAttribute('loading', 'lazy', element);
                    }
                }
            });
        });

        if (inputBody) {
            editor.setData(inputBody.value);
        }

        mainEditor = editor; // Save for future use
        document.dispatchEvent(new Event('MainEditorReady'));
    })
    .catch( error => {console.error( error );});
}