<header class="dash-page-header">
    <div>
        <h1 class="ff-body fw-500 ls-1 mb-0">Log Files</h1>
        <p class="color-300 mb-0 lh-150">Access logs related to background tasks, incoming traffic, and system errors.</p>
    </div>

    <nav class="dash-subnav" data-nav-active="<?=get_route()?>">

        <a href="<?=site_url('admin/dashboard/logs/cron')?>" class="dash-subnav__item btn-card" data-match="admin/dashboard/logs/cron">
            <h4>Cron Jobs</h4>
            <p>Scheduled tasks and background script logs</p>
            <svg class="svg-icon" aria-hidden="true">
                <use href="#chevron-next"></use>
            </svg>
        </a>

        <a href="<?=site_url('admin/dashboard/logs/hits')?>" class="dash-subnav__item btn-card" data-match="admin/dashboard/logs/hits">
            <h4>Raw Hits</h4>
            <p>Unprocessed visit logs and request activity</p>
            <svg class="svg-icon" aria-hidden="true">
                <use href="#chevron-next"></use>
            </svg>
        </a>

        <a href="<?=site_url('admin/dashboard/logs/error')?>" class="dash-subnav__item btn-card" data-match="admin/dashboard/logs/error">
            <h4>System Errors</h4>
            <p>Captured exceptions and error trace logs</p>
            <svg class="svg-icon" aria-hidden="true">
                <use href="#chevron-next"></use>
            </svg>
        </a>

    </nav>
</header>
