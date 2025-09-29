<header class="mt-10 mb-4">
    <h1 class="text-5xl mb-2">Trash & Cleanup</h1>
    <p class="text-base-content/70">Confirm deletions, recover if needed, and eliminate orphaned images to keep your platform organized and efficient.</p>
</header>

<section class="tabs tabs-lg tabs-border">
    <input type="radio" name="trash" class="tab" aria-label="Photos" checked="checked" />
    <div class="tab-content border-0 p-8">
        <p class="mb-2">Images no longer linked to any post or page.</p>
        <?= $this->include('dashboard/pages/trash/photos') ?>
    </div>

    <input type="radio" name="trash" class="tab" aria-label="Posts & Pages" />
    <div class="tab-content border-0 p-8">
        <p class="mb-2">Posts and pages removed from the site.</p>
        <?= $this->include('dashboard/pages/trash/content') ?>
    </div>

    <input type="radio" name="trash" class="tab" aria-label="Accounts" />
    <div class="tab-content border-0 p-8">
        <p class="mb-2">Inactive system users.</p>
        <?= $this->include('dashboard/pages/trash/accounts') ?>
    </div>
</section>