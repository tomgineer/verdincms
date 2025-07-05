<panel class="edit-panel" data-panel-id="edit-options">

    <div class="edit-panel__header">
        <h3 class="mb-0">Options</h3>
    </div>

    <div class="edit-panel__body">

        <div class="edit-toggle">
            <span class="edit-toggle__label">Featured</span>
            <label class="edit-toggle__switch">
                <input type="checkbox" name="featured" value="1" <?=$post['featured']==1?'checked':''?>>
                <span class="edit-toggle__slider"></span>
            </label>
        </div>

        <div class="edit-toggle">
            <span class="edit-toggle__label">Review Required</span>
            <label class="edit-toggle__switch">
                <input type="checkbox" name="review" value="1" <?=$post['review']==1?'checked':''?>>
                <span class="edit-toggle__slider"></span>
            </label>
        </div>

        <?php if ($type==='post'):?>

            <div class="edit-toggle mb-2">
                <span class="edit-toggle__label">Unlisted</span>
                <label class="edit-toggle__switch">
                    <input type="checkbox" name="unlisted" value="1" <?=$post['unlisted']==1?'checked':''?>>
                    <span class="edit-toggle__slider"></span>
                </label>
            </div>

        <?php else:?>

            <div class="edit-toggle mb-2">
                <span class="edit-toggle__label">Disable Hero</span>
                <label class="edit-toggle__switch">
                    <input type="checkbox" name="disable_hero" value="1" <?=$post['disable_hero']==1?'checked':''?>>
                    <span class="edit-toggle__slider"></span>
                </label>
            </div>

            <div class="edit-fieldset">
                <label class="edit-fieldset__label">Module</label>
                <input type="text" name="module" value="<?=esc($post['module'])?>" class="edit-fieldset__control" placeholder="Module" maxlength="50"/>
            </div>

        <?php endif;?>

        <div class="edit-fieldset">
            <label class="edit-fieldset__label">Author</label>
            <select name="user_id" class="edit-fieldset__control edit-select">
                <?php foreach ($users as $user): ?>
                    <option value="<?= esc($user['id']) ?>" <?= $post['user_id'] == $user['id'] ? 'selected' : '' ?>>
                        <?= esc($user['user']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

    </div><!-- End: Panel Body -->

</panel>