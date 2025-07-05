<panel class="edit-panel open" data-panel-id="edit-settings">
    <div class="edit-panel__header">
        <h3>Settings</h3>
    </div>

    <div class="edit-panel__body">
        <?php if ($type==='post'):?>

            <div class="edit-fieldset">
                <label class="edit-fieldset__label">Topic</label>
                <select name="topic_id" class="edit-fieldset__control edit-select">
                    <?php foreach ($topics as $topic): ?>
                        <option value="<?= esc($topic['id']) ?>" <?= $post['topic_id'] == $topic['id'] ? 'selected' : '' ?>>
                            <?= esc($topic['title']) ?> (<?= esc($topic['posts']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

        <?php else:?>

            <div class="edit-fieldset">
                <label class="edit-fieldset__label">Section</label>
                <select name="section_id" class="edit-fieldset__control edit-select">
                    <?php foreach ($sections as $section): ?>
                        <option value="<?= esc($section['id']) ?>" <?= $post['section_id'] == $section['id'] ? 'selected' : '' ?>>
                            <?= esc($section['title']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="edit-fieldset">
                <label class="edit-fieldset__label">Slug</label>
                <input type="text" name="slug" value="<?=esc($post['slug'])?>" class="edit-fieldset__control" placeholder="Slug" maxlength="50" />
            </div>

            <div class="edit-fieldset">
                <label class="edit-fieldset__label">Label</label>
                <input type="text" name="label" value="<?=esc($post['label'])?>" class="edit-fieldset__control" placeholder="Label" maxlength="50" />
            </div>

            <div class="edit-fieldset">
                <label class="edit-fieldset__label">Icon</label>
                <input type="text" name="icon" value="<?=esc($post['icon'])?>" class="edit-fieldset__control" placeholder="Icon" maxlength="20" />
            </div>

        <?php endif;?>

        <div class="edit-fieldset">
            <label class="edit-fieldset__label">Accessibility</label>
            <select name="accessibility" class="edit-fieldset__control edit-select">
                <?php foreach ($user_groups as $group): ?>
                    <option value="<?= esc($group['tier']) ?>" <?= $post['accessibility'] == $group['tier'] ? 'selected' : '' ?>>
                        <?= esc($group['title']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

    </div>

</panel>