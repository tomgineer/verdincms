<fieldset class="fieldset w-full gap-y-2">

    <label class="label gap-x-2">
        <input type="checkbox" name="featured" value="1" class="toggle toggle-primary" <?= $post['featured'] == 1 ? 'checked' : '' ?> />
        Featured
    </label>

    <label class="label gap-x-2">
        <input type="checkbox" name="review" value="1" class="toggle toggle-primary" <?= $post['review'] == 1 ? 'checked' : '' ?> />
        Review Required
    </label>

    <?php if ($type === 'post'): ?>
        <label class="label gap-x-2">
        <input type="checkbox" name="unlisted" value="1" class="toggle toggle-primary" <?= $post['unlisted'] == 1 ? 'checked' : '' ?> />
        Unlisted
        </label>
    <?php else: ?>
        <label class="label gap-x-2">
        <input type="checkbox" name="disable_hero" value="1" class="toggle toggle-primary" <?= $post['disable_hero'] == 1 ? 'checked' : '' ?> />
        Disable Hero
        </label>

        <div class="mt-2">
        <label class="label"><span class="label-text">Module</span></label>
        <input type="text"
                name="module"
                value="<?= esc($post['module']) ?>"
                class="input input-bordered w-full"
                placeholder="Module"
                maxlength="50" />
        </div>
    <?php endif; ?>
</fieldset>
