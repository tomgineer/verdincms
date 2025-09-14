<header class="mt-10 mb-4">
    <h1 class="text-5xl mb-2">Archive</h1>
    <p class="text-base-content/70">Browse posts and pages that are saved as drafts or have been deleted.</p>
</header>

<section class="tabs tabs-lg tabs-border">
    <input type="radio" name="archive" class="tab" aria-label="Posts" checked="checked" />
    <div class="tab-content border-0 p-8">
        <p class="mb-2">All draft of deleted Posts.</p>
        <?= $this->include('dashboard/pages/archive/posts') ?>
    </div>

    <input type="radio" name="archive" class="tab" aria-label="Pages" />
    <div class="tab-content border-0 p-8">
        <p class="mb-2">All draft of deleted Pages.</p>
        <?= $this->include('dashboard/pages/archive/pages') ?>
    </div>
</section>