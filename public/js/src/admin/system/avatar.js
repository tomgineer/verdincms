/**
 * Handles avatar file input change and triggers the upload process.
 *
 * This function:
 * - Attaches a listener to the input field with `[data-upload-avatar]`
 * - Triggers an animated avatar effect
 * - Calls the fetch function to handle upload via FormData
 *
 * Expects:
 * - An `<input>` with `data-upload-avatar` attribute
 * - An `<img>` element with `.users-edit-avatar__img` to animate
 * - A form with ID `#form-upload-avatar` and a `data-action` attribute pointing to the upload endpoint
 */
export default function uploadAvatar() {

    const uploadAvatar = document.querySelector('[data-upload-avatar]');
    if ( !uploadAvatar ) return;

    const imgAvatar = document.querySelector('.users-edit-avatar__img');

    uploadAvatar.addEventListener('change', (e) => {
        if(uploadAvatar.value == '') {return;}
        imgAvatar.classList.add('animate');
        uploadAvatarFetch();
    });
}

/**
 * Uploads the avatar using a `fetch` POST request.
 *
 * Submits the `#form-upload-avatar` form as FormData to the server.
 * On success:
 * - Replaces the SVG avatar with an `<img>`
 * - Sets the new avatar `src`
 * - Updates the hidden `input[name="avatar"]` with the filename
 * - Removes the loading animation
 *
 * Requires:
 * - `#form-upload-avatar` form with a `data-action` attribute
 * - `.users-edit-avatar__img` and possibly an `<svg>` fallback inside `.users-edit-avatar`
 */
function uploadAvatarFetch() {
    const formUploadAvatar       = document.querySelector('#form-upload-avatar');
    const actionPath             = formUploadAvatar.dataset.action;
    const inputAvatar            = document.querySelector('input[name="avatar"]');
    const imgAvatar              = document.querySelector('.users-edit-avatar__img');
    const svgAvatar              = document.querySelector('.users-edit-avatar > svg');

    fetch(actionPath, {method: 'POST', body: new FormData(formUploadAvatar), cache: 'no-cache'})
        .then(res => res.json())
        .then(response => {

            if ( svgAvatar ) {
                svgAvatar.remove();
                imgAvatar.classList.remove('hidden');
            }

            imgAvatar.src = response.baseurl + "images/avatars/" + response.filename + ".webp";
            inputAvatar.value = response.filename;
            imgAvatar.classList.remove('animate');
        })
        .catch(err => {console.log(err);});
}