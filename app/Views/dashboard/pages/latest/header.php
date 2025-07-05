<header class="dash-page-header">
    <div>
        <h1 class="ff-body fw-500 ls-1 mb-0">Latest Posts & Pages</h1>
        <p class="color-300 mb-0 lh-150">Recent activity from your site, including new posts and pages.</p>
    </div>

    <nav class="dash-subnav" data-nav-active="<?=get_route()?>">

        <a href="<?=site_url('admin/dashboard/latest/posts')?>" class="dash-subnav__item btn-card" data-match="admin/dashboard/latest/posts">
            <h4>Latest Posts</h4>
            <p>Published articles</p>
            <svg class="svg-icon" aria-hidden="true">
                <use href="#chevron-next"></use>
            </svg>
        </a>

        <a href="<?=site_url('admin/dashboard/latest/pages')?>" class="dash-subnav__item btn-card" data-match="admin/dashboard/latest/pages">
            <h4>Latest Pages</h4>
            <p>Recently created site pages</p>
            <svg class="svg-icon" aria-hidden="true">
                <use href="#chevron-next"></use>
            </svg>
        </a>

    </nav>
</header>
