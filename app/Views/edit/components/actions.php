<nav class="edit-actions">

    <?php if ($type==='post'):?>
        <a href="<?=site_url('post/'.esc($post['id']))?>" class="edit-actions__item" data-action="preview">
            <svg class="svg-icon" aria-hidden="true">
                <use href="#eye"></use>
            </svg>
            <span>Preview</span>
        </a>
    <?php else:?>
        <a href="<?=site_url('preview/'.esc($post['slug']))?>" class="edit-actions__item" data-action="preview">
            <svg class="svg-icon" aria-hidden="true">
                <use href="#eye"></use>
            </svg>
            <span>Preview</span>
        </a>
    <?php endif;?>

    <button class="edit-actions__item" type="button" data-action="publish">
        <svg class="svg-icon" aria-hidden="true">
            <use href="#publish"></use>
        </svg>
        <span>Publish</span>
    </button>

    <button class="edit-actions__item" type="button" data-action="unpublish">
        <svg class="svg-icon" aria-hidden="true">
            <use href="#unpublish"></use>
        </svg>
        <span>Unpublish</span>
    </button>

    <button class="edit-actions__item" type="button" data-action="delete">
        <svg class="svg-icon" aria-hidden="true">
            <use href="#delete"></use>
        </svg>
        <span>Delete</span>
    </button>

    <button class="edit-actions__item" type="button" data-action="reset-date">
        <svg class="svg-icon" aria-hidden="true">
            <use href="#calendar"></use>
        </svg>
        <span>Reset Date</span>
    </button>

    <button class="edit-actions__item" type="button" data-action="inline-photo">
        <svg class="svg-icon" aria-hidden="true">
            <use href="#photo"></use>
        </svg>
        <span>Insert Photo</span>
    </button>
    <input type="file" id="inlinePhotoInput" accept="image/*" class="hidden">

    <button class="edit-actions__item" type="button" data-action="clear-photo">
        <svg class="svg-icon" aria-hidden="true">
            <use href="#mop"></use>
        </svg>
        <span>Clear Photo</span>
    </button>

    <button class="edit-actions__item" type="button" data-action="save-content" data-type="<?=$type?>">
        <svg class="svg-icon" aria-hidden="true">
            <use href="#save"></use>
        </svg>
        <span>Save</span>
    </button>

</nav>