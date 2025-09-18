<header class="mt-10 mb-8">
    <h1 class="text-5xl mb-2">Welcome, <?=session('firstname')?>!</h1>
    <p class="text-base-content/70">Configure settings, manage content and users, monitor system health, and run maintenance tools, all in one place.</p>
</header>

<section class="grid grid-cols-2 gap-8 mb-16">
    <div class="chart-container h-[40vh]">
        <h4>Visitors & Hits — Last 14 Days</h4>
        <canvas class="dash-chart" data-json="<?=chart_data($chart_visitors)?>" data-type="bar"></canvas>
    </div>

    <div class="chart-container h-[40vh]">
        <h4>Posting Activity — Last 14 Days</h4>
        <canvas class="dash-chart" data-json="<?=chart_data($posting_activity)?>" data-type="bar"></canvas>
    </div>
</section>

<section class="tabs tabs-lg tabs-border">
    <input type="radio" name="dashboard" class="tab" aria-label="Primary Actions" checked="checked" />
    <div class="tab-content border-0 p-8">
        <p class="mb-8">This section provides utilities for version control, manual Cron execution, and system maintenance, including cleanup of orphaned files, soft-deleted records, and cache.</p>
        <nav class="grid grid-cols-[250px_1fr] items-center gap-4">
            <?= $this->include('dashboard/pages/home/actions_primary') ?>
        </nav>
    </div>

    <input type="radio" name="dashboard" class="tab" aria-label="System Utilities" />
    <div class="tab-content border-0 p-8">
        <p class="mb-8">This section provides utilities for SEO (robots and sitemap generation), statistics optimization, role-based testing, AI execution, and updating content-related data such as topics and popular posts.</p>
        <nav class="grid grid-cols-[250px_1fr] items-center gap-4">
            <?= $this->include('dashboard/pages/home/actions_utilities') ?>
        </nav>
    </div>

    <input type="radio" name="dashboard" class="tab" aria-label="Sorting Options" />
    <div class="tab-content border-0 p-8">
        <p class="mb-8">Manage the order in which pages, topics, sections, and settings appear in menus and the admin panel.</p>
        <nav class="grid grid-cols-[250px_1fr] items-center gap-4">
            <?= $this->include('dashboard/pages/home/actions_sortable') ?>
        </nav>
    </div>

    <input type="radio" name="dashboard" class="tab" aria-label="System Cleanup" />
    <div class="tab-content border-0 p-8">
        <p class="mb-8">This section provides maintenance utilities to purge logs, cache, expired session files, and orphaned media files, helping keep the system optimized and clutter-free.</p>
        <nav class="grid grid-cols-[250px_1fr] items-center gap-4">
            <?= $this->include('dashboard/pages/home/actions_cleanup') ?>
        </nav>
    </div>

    <input type="radio" name="dashboard" class="tab" aria-label="Critical Actions" />
    <div class="tab-content border-0 p-8 bg-error-content">
        <p class="mb-8">
            These actions perform irreversible changes such as resetting data or replacing photos with placeholders.
            Use them only if you fully understand their impact.
            <span class="font-bold text-error">Caution: These operations cannot be undone!</span>
        </p>
        <nav class="grid grid-cols-[250px_1fr] items-center gap-4">
            <?= $this->include('dashboard/pages/home/actions_critical') ?>
        </nav>
    </div>

    <input type="radio" name="dashboard" class="tab" aria-label="Administration Links" />
    <div class="tab-content border-0 p-8">
        <p class="mb-8">Useful links for quick access to system functions.</p>
        <nav class="grid grid-cols-[250px_1fr] items-center gap-4">
            <?= $this->include('dashboard/pages/home/actions_links') ?>
        </nav>
    </div>
</section>
