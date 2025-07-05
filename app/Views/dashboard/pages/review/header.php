<header class="dash-page-header">
    <div>
        <h1 class="ff-body fw-500 ls-1 mb-0">Review</h1>
        <p class="color-300 mb-0 lh-150">Pages and posts awaiting editorial review, approval, or final edits.</p>
    </div>

    <nav class="dash-subnav" data-nav-active="<?=get_route()?>">

        <a href="<?=site_url('admin/dashboard/review/posts')?>" class="dash-subnav__item btn-card" data-match="admin/dashboard/review/posts">
            <h4>Posts</h4>
            <p>Blog posts awaiting review and approval</p>
            <svg class="svg-icon" aria-hidden="true">
                <use href="#chevron-next"></use>
            </svg>
        </a>

        <a href="<?=site_url('admin/dashboard/review/pages')?>" class="dash-subnav__item btn-card" data-match="admin/dashboard/review/pages">
            <h4>Pages</h4>
            <p>Pages requiring updates or approval</p>
            <svg class="svg-icon" aria-hidden="true">
                <use href="#chevron-next"></use>
            </svg>
        </a>

    </nav>
</header>
