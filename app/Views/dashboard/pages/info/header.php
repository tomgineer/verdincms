<header class="dash-page-header">
    <div>
        <h1 class="ff-body fw-500 ls-1 mb-0">System Information</h1>
        <p class="color-300 mb-0 lh-150">Detailed overview of the PHP environment, server configuration, and system capabilities.</p>
    </div>

    <nav class="dash-subnav" data-nav-active="<?=get_route()?>">
        <a href="<?=site_url('admin/dashboard/info/overview')?>" class="dash-subnav__item btn-card" data-match="admin/dashboard/info/overview">
            <h4>Overview</h4>
            <p>Core versions, environment, and runtime configuration</p>
            <svg class="svg-icon" aria-hidden="true">
                <use href="#chevron-next"></use>
            </svg>
        </a>

        <a href="<?=site_url('admin/dashboard/info/environment')?>" class="dash-subnav__item btn-card" data-match="admin/dashboard/info/environment">
            <h4>PHP & GD Info</h4>
            <p>Environment, PHP version, GD support</p>
            <svg class="svg-icon" aria-hidden="true">
                <use href="#chevron-next"></use>
            </svg>
        </a>

        <a href="<?=site_url('admin/dashboard/info/session')?>" class="dash-subnav__item btn-card" data-match="admin/dashboard/info/session">
            <h4>Palette & Session Data</h4>
            <p>UI color palette and current session values</p>
            <svg class="svg-icon" aria-hidden="true">
                <use href="#chevron-next"></use>
            </svg>
        </a>
    </nav>

</header>

