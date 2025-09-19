<dialog id="modal_blocks" class="modal" open>

    <div class="modal-box w-11/12 max-w-7xl min-h-[50rem] flex flex-col">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <h3 class="text-2xl font-bold mb-2">Edit Block</h3>
        <p class="text-sm text-base-content/70">Update the content and settings for this block as needed.</p>

        <section class="mt-4 flex-1 overflow-y-auto" data-autofill-form="blocks">

            <div class="tabs tabs-border">
                <input type="radio" name="tabs_blocks" class="tab" aria-label="General" checked="checked" />
                <div class="tab-content p-4">

                    <div class="grid grid-cols-3 gap-4">
                        <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-full border p-4 col-span-2 row-span-2">
                            <legend class="fieldset-legend">Content</legend>

                            <label class="label">Title</label>
                            <input type="text" class="input w-full" name="title" placeholder="Title" maxlength="300" />

                            <label class="label">Subtitle</label>
                            <input type="text" class="input w-full" name="subtitle" placeholder="Subtitle" maxlength="300" />

                            <label class="label">Body</label>
                            <textarea class="textarea w-full simple-editor" name="body" placeholder="Body"></textarea>
                        </fieldset>

                        <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-full border p-4">
                            <legend class="fieldset-legend">Main Attributes</legend>

                            <label class="label">ID</label>
                            <input type="text" class="input input-neutral w-full" name="id" placeholder="ID" readonly value="2" />

                            <label class="label">Alias</label>
                            <input type="text" class="input w-full" name="alias" placeholder="Alias" maxlength="50" />

                            <label class="label">Group</label>
                            <select class="select w-full" name="block_group_id" data-table="block_groups" data-column="title" data-autofill-select>
                            </select>

                            <label class="label">Description</label>
                            <textarea class="textarea w-full" name="description" placeholder="Description" maxlength="255" rows="7"></textarea>
                        </fieldset>

                    </div>
                </div>

                <input type="radio" name="tabs_blocks" class="tab" aria-label="Advanced" />
                <div class="tab-content p-4">

                    <div class="grid grid-cols-3 gap-4">
                        <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-full border p-4">
                            <legend class="fieldset-legend">Texts</legend>

                            <label class="label">Text 1</label>
                            <input type="text" class="input w-full" name="text1" placeholder="Text 1" maxlength="100" />

                            <label class="label">Text 2</label>
                            <input type="text" class="input w-full" name="text2" placeholder="Text 2" maxlength="100" />

                            <label class="label">Text 3</label>
                            <input type="text" class="input w-full" name="text3" placeholder="Text 3" maxlength="100" />

                            <label class="label">Text 4</label>
                            <input type="text" class="input w-full" name="text4" placeholder="Text 4" maxlength="100" />

                            <label class="label">Text 5</label>
                            <input type="text" class="input w-full" name="text5" placeholder="Text 5" maxlength="100" />
                        </fieldset>

                        <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-full border p-4">
                            <legend class="fieldset-legend">Links</legend>

                            <label class="label">Link 1</label>
                            <input type="text" class="input w-full" name="link1" placeholder="Link 1" maxlength="255" />

                            <label class="label">Link 2</label>
                            <input type="text" class="input w-full" name="link2" placeholder="Link 2" maxlength="255" />

                            <label class="label">Link 3</label>
                            <input type="text" class="input w-full" name="link3" placeholder="Link 3" maxlength="255" />

                            <label class="label">Link 4</label>
                            <input type="text" class="input w-full" name="link4" placeholder="Link 4" maxlength="255" />

                            <label class="label">Link 5</label>
                            <input type="text" class="input w-full" name="link5" placeholder="Link 5" maxlength="255" />
                        </fieldset>


                        <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-full border p-4">
                            <legend class="fieldset-legend">Media</legend>

                            <label class="label">Image</label>
                            <input type="file" class="file-input w-full" name="image" />
                            <p class="label text-base-content" data-field-desc="image">No file selected.</p>

                            <label class="label">Background</label>
                            <input type="file" class="file-input w-full" name="background" />
                            <p class="label text-base-content" data-field-desc="background">No file selected.</p>
                        </fieldset>
                    </div>

                </div>
            </div>

        </section>

        <nav class="flex gap-4 justify-end">
            <form method="dialog">
                <button class="btn btn-soft">Cancel</button>
            </form>
            <button class="btn btn-success" type="button" data-save-form>Save</button>
        </nav>

    </div>

</dialog>