<header class="mt-10 mb-4">
    <h1 class="text-5xl mb-2">Latest Posts & Pages</h1>
    <p class="text-base-content/70">Recent activity from your site, including new posts and pages.</p>
</header>

<section class="tabs tabs-lg tabs-border">
    <input type="radio" name="latest" class="tab" aria-label="Posts" checked="checked" />
    <div class="tab-content border-0 p-8">
        <p class="mb-2">Recently created posts.</p>
        <?= $this->include('dashboard/pages/latest/posts') ?>
    </div>

    <input type="radio" name="latest" class="tab" aria-label="Pages" />
    <div class="tab-content border-0 p-8">
        <p class="mb-2">Recently created pages.</p>
        <?= $this->include('dashboard/pages/latest/pages') ?>
    </div>
</section>