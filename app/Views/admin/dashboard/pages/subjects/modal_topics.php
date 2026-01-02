<dialog id="modalTopics" class="modal">

    <div class="modal-box w-11/12 max-w-5xl min-h-[40rem] flex flex-col">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <h3 class="text-2xl font-bold mb-2">Edit Topic</h3>
        <p class="text-sm text-base-content/70">Modify the topic’s details and adjust its settings to fit your needs.</p>

        <section class="mt-4 flex-1 overflow-y-auto grid grid-cols-4 gap-4" data-autofill-form="topics">

            <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-full border p-4 col-span-3">
                <legend class="fieldset-legend">General Settings</legend>

                <label class="label">Title</label>
                <input type="text" class="input w-full" name="title" placeholder="Title" maxlength="100" />

                <label class="label">Slug</label>
                <input type="text" class="input w-full" name="slug" placeholder="Slug" maxlength="50" />
                <p class="label text-base-content/40">A unique identifier used to generate the topic’s URL</p>

                <label class="label my-2">
                    <input type="checkbox" name="featured" class="toggle checked:toggle-accent" />
                    Featured
                </label>

                <label class="label">Description</label>
                <textarea class="textarea w-full simple-editor" name="description" placeholder="Description"></textarea>
                <p class="label text-base-content/40">This field is optional</p>
            </fieldset>

            <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-full border p-4">
                <legend class="fieldset-legend">Info</legend>

                <label class="label">ID</label>
                <input type="text" class="input input-neutral w-full text-accent" name="id" placeholder="ID" readonly value="" />

                <label class="label">Position</label>
                <input type="text" class="input input-neutral w-full text-accent" name="position" placeholder="Position" readonly />

                <label class="label">Number of Posts</label>
                <input type="text" class="input input-neutral w-full text-accent" name="posts" placeholder="Number of Posts" readonly />
            </fieldset>

        </section>

        <nav class="flex gap-2 justify-end mt-4">
            <form method="dialog">
                <button class="btn btn-ghost">Cancel</button>
            </form>
            <button class="btn btn-success" type="button" data-save-form>Save Topic</button>
        </nav>

    </div>

</dialog>
