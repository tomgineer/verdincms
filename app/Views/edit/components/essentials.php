<fieldset class="fieldset bg-base-100 border-base-300 rounded-box w-full border p-4 gap-y-2">
    <legend class="fieldset-legend">Essentials</legend>

    <?php if ($type === 'post'): ?>

        <label class="label">Topic</label>
        <select name="topic_id" class="select w-full">
            <?php foreach ($topics as $topic): ?>
                <option value="<?= esc($topic['id']) ?>" <?= $post['topic_id'] == $topic['id'] ? 'selected' : '' ?>>
                    <?= esc($topic['title']) ?> (<?= esc($topic['posts']) ?>)
                </option>
            <?php endforeach; ?>
        </select>

    <?php else: ?>

        <label class="label">Section</label>
        <select name="section_id" class="select w-full">
            <?php foreach ($sections as $section): ?>
                <option value="<?= esc($section['id']) ?>" <?= $post['section_id'] == $section['id'] ? 'selected' : '' ?>>
                    <?= esc($section['title']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label class="label">Slug</label>
        <input type="text"
                name="slug"
                value="<?= esc($post['slug']) ?>"
                class="input w-full"
                placeholder="Slug"
                maxlength="50" />

        <label class="label">Label</label>
        <input type="text"
                name="label"
                value="<?= esc($post['label']) ?>"
                class="input w-full"
                placeholder="Label"
                maxlength="50" />

        <label class="label">Icon</label>
        <input type="text"
                name="icon"
                value="<?= esc($post['icon']) ?>"
                class="input w-full"
                placeholder="Icon"
                maxlength="20" />

    <?php endif; ?>

    <label class="label">Accessibility</label>
    <select name="accessibility" class="select w-full">
        <?php foreach ($user_groups as $group): ?>
            <option value="<?= esc($group['tier']) ?>" <?= $post['accessibility'] == $group['tier'] ? 'selected' : '' ?>>
                <?= esc($group['title']) ?>
            </option>
        <?php endforeach; ?>
    </select>

</fieldset>