<header class="dash-page-header">
    <div>
        <h1 class="ff-body fw-500 ls-1 mb-0">Trash & Cleanup: Deleted Items and Orphaned Content</h1>
        <p class="color-300 mb-0 lh-150">Review and manage deleted accounts, content, and orphaned photos.</p>
    </div>

    <nav class="dash-subnav" data-nav-active="<?=get_route()?>">

        <a href="<?=site_url('admin/dashboard/trash/photos')?>" class="dash-subnav__item btn-card" data-match="admin/dashboard/trash/photos">
            <h4>Orphan Photos</h4>
            <p>Images no longer linked to any post or page</p>
            <svg class="svg-icon" aria-hidden="true">
                <use href="#chevron-next"></use>
            </svg>
        </a>

        <a href="<?=site_url('admin/dashboard/trash/content')?>" class="dash-subnav__item btn-card" data-match="admin/dashboard/trash/content">
            <h4>Deleted Content</h4>
            <p>Posts and pages removed from the site</p>
            <svg class="svg-icon" aria-hidden="true">
                <use href="#chevron-next"></use>
            </svg>
        </a>

        <a href="<?=site_url('admin/dashboard/trash/accounts')?>" class="dash-subnav__item btn-card" data-match="admin/dashboard/trash/accounts">
            <h4>Deleted Accounts</h4>
            <p>Inactive system users</p>
            <svg class="svg-icon" aria-hidden="true">
                <use href="#chevron-next"></use>
            </svg>
        </a>

    </nav>
</header>
