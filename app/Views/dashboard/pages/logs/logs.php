<header class="mt-10 mb-4">
    <h1 class="text-5xl mb-2">Log Files</h1>
    <p class="text-base-content/70">Access logs related to background tasks, incoming traffic, and system errors.</p>
</header>

<section class="tabs tabs-lg tabs-border">
    <input type="radio" name="logs" class="tab" aria-label="Cron Jobs" checked="checked" />
    <div class="tab-content border-0 p-8">
        <p class="mb-2">Scheduled tasks and background script logs.</p>
        <?= $this->include('dashboard/pages/logs/cron') ?>
    </div>

    <input type="radio" name="logs" class="tab" aria-label="Raw Hits" />
    <div class="tab-content border-0 p-8">
        <p class="mb-2">Unprocessed visit logs and request activity.</p>
        <?= $this->include('dashboard/pages/logs/hits') ?>
    </div>

    <input type="radio" name="logs" class="tab" aria-label="System Errors" />
    <div class="tab-content border-0 p-8 bg-error-content">
        <p class="mb-2">Captured exceptions and error trace logs.</p>
        <?= $this->include('dashboard/pages/logs/error') ?>
    </div>
</section>