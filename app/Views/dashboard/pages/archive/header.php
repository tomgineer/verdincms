<header class="dash-page-header">
    <div>
        <h1 class="ff-body fw-500 ls-1 mb-0">Archive</h1>
        <p class="color-300 mb-0 lh-150">Browse posts and pages that are saved as drafts or have been deleted.</p>
    </div>

    <nav class="dash-subnav" data-nav-active="<?=get_route()?>">

        <a href="<?=site_url('admin/dashboard/archive/posts')?>" class="dash-subnav__item btn-card" data-match="admin/dashboard/archive/posts">
            <h4>Posts</h4>
            <p>View all draft or deleted posts</p>
            <svg class="svg-icon" aria-hidden="true">
                <use href="#chevron-next"></use>
            </svg>
        </a>

        <a href="<?=site_url('admin/dashboard/archive/pages')?>" class="dash-subnav__item btn-card" data-match="admin/dashboard/archive/pages">
            <h4>Pages</h4>
            <p>View all draft or deleted pages</p>
            <svg class="svg-icon" aria-hidden="true">
                <use href="#chevron-next"></use>
            </svg>
        </a>

    </nav>
</header>
