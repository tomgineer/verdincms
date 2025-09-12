<div class="grid grid-cols-2 gap-1 mb-4">

    <?php if ($type === 'post'): ?>
        <a href="<?= site_url('post/'.esc($post['id'])) ?>" class="btn btn-soft btn-info" data-action="preview">Preview</a>
    <?php else: ?>
        <a href="<?= site_url('preview/'.esc($post['slug'])) ?>" class="btn btn-soft btn-info" data-action="preview">Preview</a>
    <?php endif; ?>

    <button class="btn btn-success" type="button" data-action="save-content" data-type="<?= $type ?>">Save</button>

    <button class="btn btn-soft btn-success flex-1" type="button" data-action="publish">Publish</button>
    <button class="btn btn-soft" type="button" data-action="unpublish">Unpublish</button>
    <button class="btn btn-soft" type="button" data-action="delete">Delete</button>

    <button class="btn btn-soft" type="button" data-action="reset-date">Reset Date</button>
    <button class="btn btn-soft" type="button" data-action="clear-photo">Clear Photo</button>
    <label for="inlinePhotoInput" class="btn btn-soft btn-secondary" data-action="inline-photo">Insert Photo</label>
    <input type="file" id="inlinePhotoInput" accept="image/*" class="hidden" />

</div>


