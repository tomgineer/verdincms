<header class="mt-10 mb-4">
    <h1 class="text-5xl mb-2">Newsletter</h1>
    <p class="text-base-content/70">Manage your subscribers and create engaging newsletters.</p>
</header>

<section class="tabs tabs-lg tabs-border">
    <input type="radio" name="newsletter" class="tab" aria-label="Subscribers" checked="checked" />
    <div class="tab-content border-0 p-8">
        <p class="mb-2">Monitor your subscriber list, including active and unsubscribed members.</p>
        <?= $this->include('admin/dashboard/pages/newsletter/subscribers') ?>
    </div>

    <input type="radio" name="newsletter" class="tab" aria-label="Composer" />
    <div class="tab-content border-0 p-8">
        <p class="mb-2">Design and distribute new newsletters to your subscriber list.</p>
        <?= $this->include('admin/dashboard/pages/newsletter/composer') ?>
    </div>

    <input type="radio" name="newsletter" class="tab" aria-label="Export" />
    <div class="tab-content border-0 p-8">
        <p class="mb-2">Export active subscribers list.</p>
        <?= $this->include('admin/dashboard/pages/newsletter/export') ?>
    </div>

</section>
