<div class="fixed right-0 bottom-0 w-1/5 top-0 z-50 bg-base-200 p-2 pt-16 overflow-y-auto overscroll-contain">
    <?= $this->include('admin/edit/partials/menu') ?>
    <?= $this->include('admin/edit/partials/photo') ?>
    <?= $this->include('admin/edit/partials/essentials') ?>

    <div class="tabs tabs-border mt-2">
        <input type="radio" name="content_info" class="tab" aria-label="Content Info" checked="checked" />
        <div class="tab-content border-base-300 bg-base-100 p-4">
            <?= $this->include('admin/edit/partials/info') ?>
        </div>

        <input type="radio" name="content_info" class="tab" aria-label="Options" />
        <div class="tab-content border-base-300 bg-base-100 p-4">
            <?= $this->include('admin/edit/partials/options') ?>
        </div>

        <input type="radio" name="content_info" class="tab" aria-label="Advanced" />
        <div class="tab-content border-base-300 bg-base-100 p-4">
            <?= $this->include('admin/edit/partials/advanced') ?>
        </div>
    </div>

</div>
