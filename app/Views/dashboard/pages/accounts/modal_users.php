<dialog id="modalUsers" class="modal">

    <div class="modal-box w-11/12 max-w-7xl min-h-[56rem] flex flex-col">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <h3 class="text-2xl font-bold mb-2">Edit User</h3>
        <p class="text-sm text-base-content/70">Update the user's information and manage their account settings.</p>

        <section class="mt-4 flex-1 overflow-y-auto" data-autofill-form="users">

            <div class="tabs tabs-border">
                <input type="radio" name="tabs_blocks" class="tab" aria-label="General" checked="checked" />
                <div class="tab-content p-4">

                    <div class="grid grid-cols-3 gap-4">
                        <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-full border p-4 col-span-2">
                            <legend class="fieldset-legend">Account</legend>

                            <label class="label">Email</label>
                            <input type="email" class="input w-full" name="email" placeholder="Email" maxlength="320" />

                            <label class="label">Password</label>
                            <input type="password" class="input w-full" name="password" placeholder="Leave blank to keep current password" maxlength="70" />

                            <label class="label">Group</label>
                            <select class="select w-full" name="user_group_id" data-table="user_groups" data-column="title" data-autofill-select>
                            </select>

                            <label class="label">Status</label>
                            <select class="select w-full" name="status">
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                                <option value="0">Deleted</option>
                            </select>

                        </fieldset>

                        <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-full border p-4 row-span-2">
                            <legend class="fieldset-legend">Profile Data</legend>

                            <label class="label">Avatar</label>
                            <input type="file" class="file-input w-full" data-path="images/avatars" data-input="avatar" accept="image/*" />
                            <input type="text" class="pointer-events-none text-accent" name="avatar" readonly placeholder="No file selected">

                            <label class="label">Expiration</label>
                            <input type="date" class="input w-full" name="expiration" placeholder="Expiration" />

                            <label class="label">ID</label>
                            <input type="text" class="input input-neutral w-full text-accent" name="id" placeholder="ID" readonly value="" />

                            <label class="label">Modified</label>
                            <input type="text" class="input input-neutral w-full text-accent" name="modified" placeholder="Modified" readonly />

                            <label class="label">Created</label>
                            <input type="text" class="input input-neutral w-full text-accent" name="created" placeholder="Created" readonly />
                        </fieldset>

                        <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-full border p-4 col-span-2">
                            <legend class="fieldset-legend">Personal Information</legend>

                            <label class="label">First Name</label>
                            <input type="text" class="input w-full" name="first_name" placeholder="First Name" maxlength="50" />

                            <label class="label">Last Name</label>
                            <input type="text" class="input w-full" name="last_name" placeholder="Last Name" maxlength="50" />

                            <label class="label">Nickname</label>
                            <input type="text" class="input w-full" name="author" placeholder="Nickname" maxlength="50" />
                            <p class="text-sm text-base-content/40">This name will be shown instead of your full name</p>
                        </fieldset>
                    </div>
                </div>

                <input type="radio" name="tabs_blocks" class="tab" aria-label="Advanced" />
                <div class="tab-content p-4">

                    <div class="grid grid-cols-2 gap-4">
                        <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-full border p-4">
                            <legend class="fieldset-legend">Organizational Role</legend>

                            <label class="label">Department</label>
                            <input type="text" class="input w-full" name="department" placeholder="Department" maxlength="50" />

                            <label class="label">Position</label>
                            <input type="text" class="input w-full" name="position" placeholder="Position" maxlength="150" />

                            <label class="label">Stand-in</label>
                            <select class="select w-full" name="standin_id" data-table="users" data-column="last_name" data-autofill-select>
                            </select>
                            <p class="text-sm text-base-content/40">
                                Select the employee who will temporarily act as a substitute for this person.
                            </p>

                            <label class="label">Abbreviation</label>
                            <input type="text" class="input w-full" name="abbreviation" placeholder="Abbreviation" maxlength="5" />
                            <p class="text-sm text-base-content/40">Short code used internally to identify this employee</p>

                        </fieldset>

                        <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-full border p-4">
                            <legend class="fieldset-legend">Office</legend>

                            <label class="label">Room</label>
                            <input type="text" class="input w-full" name="room" placeholder="Room" maxlength="10" />

                            <label class="label">Phone</label>
                            <input type="text" class="input w-full" name="phone" placeholder="Phone" maxlength="20" />

                            <label class="label">Phone Extension</label>
                            <input type="text" class="input w-full" name="phone_extension" placeholder="Phone Extension" maxlength="5" />
                            <p class="text-sm text-base-content/40">Used to reach this office via internal phone system.</p>

                        </fieldset>

                    </div>

                </div>
            </div>

        </section>

        <nav class="flex gap-2 justify-end">
            <form method="dialog">
                <button class="btn btn-ghost">Cancel</button>
            </form>
            <button class="btn btn-success" type="button" data-save-form>Save User</button>
        </nav>

    </div>

</dialog>