<dialog id="modalSections" class="modal">

    <div class="modal-box w-11/12 max-w-5xl min-h-[40rem] flex flex-col">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <h3 class="text-2xl font-bold mb-2">Edit Section</h3>
        <p class="text-sm text-base-content/70">Update the content and configuration of this section as needed.</p>

        <section class="mt-4 flex-1 overflow-y-auto grid grid-cols-4 gap-4" data-autofill-form="sections">

            <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-full border p-4 col-span-3">
                <legend class="fieldset-legend">Title</legend>
                <input type="text" class="input w-full" name="title" placeholder="Title" maxlength="100" />

                <legend class="fieldset-legend">Slug</legend>
                <input type="text" class="input w-full" name="slug" placeholder="Slug" maxlength="50" />
                <p class="label">A unique identifier used to generate the section’s URL</p>

                <legend class="fieldset-legend">Description</legend>
                <textarea class="textarea w-full resize-none" name="description" placeholder="Description" maxlength="255" rows="5"></textarea>
                <p class="label">This field is optional</p>

                <legend class="fieldset-legend">Featured</legend>
                <input type="checkbox" name="featured" class="toggle checked:toggle-accent" />

            </fieldset>

            <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-full border p-4">
                <legend class="fieldset-legend">ID</legend>
                <input type="text" class="input input-neutral w-full text-accent" name="id" placeholder="ID" readonly value="11" />

                <legend class="fieldset-legend">Position</legend>
                <input type="text" class="input input-neutral w-full text-accent" name="position" placeholder="Position" readonly />

                <legend class="fieldset-legend">Number of Pages</legend>
                <input type="text" class="input input-neutral w-full text-accent" name="pages" placeholder="Number of Pages" readonly />

            </fieldset>

        </section>

        <nav class="flex gap-4 justify-end mt-4">
            <form method="dialog">
                <button class="btn btn-soft">Cancel</button>
            </form>
            <button class="btn btn-success" type="button" data-save-form>Save</button>
        </nav>

    </div>

</dialog>