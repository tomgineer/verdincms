<fieldset class="fieldset w-full gap-y-2">

    <label class="label">Accessibility</label>
    <select name="accessibility" class="select w-full">
        <?php foreach ($user_groups as $group): ?>
            <option value="<?= esc($group['tier']) ?>" <?= $post['accessibility'] == $group['tier'] ? 'selected' : '' ?>>
                <?= esc($group['title']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <?php if ($type === 'page'): ?>
        <label class="label">Icon</label>
        <input type="text"
                name="icon"
                value="<?= esc($post['icon']) ?>"
                class="input w-full"
                placeholder="Icon"
                maxlength="20" />
    <?php endif; ?>

    <label class="label">Author</label>
    <select name="user_id" class="select w-full">
        <?php foreach ($users as $user): ?>
        <option value="<?= esc($user['id']) ?>" <?= $post['user_id'] == $user['id'] ? 'selected' : '' ?>>
            <?= esc($user['user']) ?>
        </option>
        <?php endforeach; ?>
    </select>

</fieldset>
