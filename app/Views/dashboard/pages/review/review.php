<header class="mt-10 mb-4">
    <h1 class="text-5xl mb-2">Review</h1>
    <p class="text-base-content/70">Pages and posts awaiting editorial review, approval, or final edits.</p>
</header>

<section class="tabs tabs-lg tabs-border">
    <input type="radio" name="review" class="tab" aria-label="Posts" checked="checked" />
    <div class="tab-content border-0 p-8">
        <p class="mb-2">Posts awaiting review and approval.</p>
        <?= $this->include('dashboard/pages/review/posts') ?>
    </div>

    <input type="radio" name="review" class="tab" aria-label="Pages" />
    <div class="tab-content border-0 p-8">
        <p class="mb-2">Pages requiring updates or approval.</p>
        <?= $this->include('dashboard/pages/review/pages') ?>
    </div>
</section>