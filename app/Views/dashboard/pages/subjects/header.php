<header class="dash-page-header">
    <div>
        <h1 class="ff-body fw-500 ls-1 mb-0">Subjects</h1>
        <p class="color-300 mb-0 lh-150">Browse through the available topics and sections.</p>
    </div>

    <nav class="dash-subnav" data-nav-active="<?=get_route()?>">

        <a href="<?=site_url('admin/dashboard/subjects/topics')?>" class="dash-subnav__item btn-card" data-match="admin/dashboard/subjects/topics">
            <h4>Topics</h4>
            <p>View and manage all topics.</p>
            <svg class="svg-icon" aria-hidden="true">
                <use href="#chevron-next"></use>
            </svg>
        </a>

        <a href="<?=site_url('admin/dashboard/subjects/sections')?>" class="dash-subnav__item btn-card" data-match="admin/dashboard/subjects/sections">
            <h4>Sections</h4>
            <p>Organize and edit your sections.</p>
            <svg class="svg-icon" aria-hidden="true">
                <use href="#chevron-next"></use>
            </svg>
        </a>

    </nav>
</header>
