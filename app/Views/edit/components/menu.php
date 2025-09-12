<div class="grid grid-cols-3 gap-2 mb-4">

    <?php if ($type === 'post'): ?>
        <a href="<?= site_url('post/'.esc($post['id'])) ?>" class="btn btn-sm btn-soft hover:btn-primary" data-action="preview">Preview</a>
    <?php else: ?>
        <a href="<?= site_url('preview/'.esc($post['slug'])) ?>" class="btn btn-sm btn-soft hover:btn-primary" data-action="preview">Preview</a>
    <?php endif; ?>

    <label for="inlinePhotoInput" class="btn btn-sm btn-soft hover:btn-primary" data-action="inline-photo">Insert Photo</label>
    <input type="file" id="inlinePhotoInput" accept="image/*" class="hidden" />

    <button class="btn btn-sm btn-soft btn-success" type="button" data-action="save-content" data-type="<?= $type ?>">Save</button>

    <button class="btn btn-sm btn-soft btn-error" type="button" data-action="delete">Delete</button>
    <button class="btn btn-sm btn-soft hover:btn-primary" type="button" data-action="unpublish">Unpublish</button>
    <button class="btn btn-sm btn-soft btn-success" type="button" data-action="publish">Publish</button>

    <button class="btn btn-sm btn-ghost hover:btn-primary" type="button" data-action="reset-date">Reset Date</button>
    <button class="btn btn-sm btn-ghost hover:btn-primary" type="button" data-action="clear-photo">Clear Photo</button>

</div>


