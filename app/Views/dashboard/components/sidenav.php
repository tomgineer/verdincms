<nav class="dash-sidenav" data-nav-active="<?=get_route()?>">
    <a href="<?=site_url('admin/dashboard')?>"
        data-match="admin/dashboard"
        class="dash-sidenav__item">
        <svg class="svg-icon" aria-hidden="true">
            <use href="#home"></use>
        </svg>
        <span>Home</span>
    </a>

    <a href="<?=site_url('admin/dashboard/archive/posts')?>"
        data-match="admin/dashboard/archive/posts, admin/dashboard/archive/pages"
        class="dash-sidenav__item">
        <svg class="svg-icon" aria-hidden="true">
            <use href="#archive"></use>
        </svg>
        <span>Archive</span>
    </a>

    <a href="<?=site_url('admin/dashboard/blocks/blocks')?>"
        data-match="admin/dashboard/blocks/blocks"
        class="dash-sidenav__item">
        <svg class="svg-icon" aria-hidden="true">
            <use href="#brick"></use>
        </svg>
        <span>Blocks</span>
    </a>

    <a href="<?=site_url('admin/dashboard/subjects/topics')?>"
        data-match="admin/dashboard/subjects/topics, admin/dashboard/subjects/sections"
        class="dash-sidenav__item">
        <svg class="svg-icon" aria-hidden="true">
            <use href="#folder"></use>
            <span>Subjects</span>
        </svg>
    </a>

    <a href="<?=site_url('admin/dashboard/accounts/users')?>"
        data-match="admin/dashboard/accounts/users"
        class="dash-sidenav__item">
        <svg class="svg-icon" aria-hidden="true">
            <use href="#users"></use>
        </svg>
        <span>Accounts</span>
    </a>

    <a href="<?=site_url('admin/dashboard/latest/posts')?>"
        data-match="admin/dashboard/latest/posts, admin/dashboard/latest/pages"
        class="dash-sidenav__item">
        <svg class="svg-icon" aria-hidden="true">
            <use href="#clock"></use>
        </svg>
        <span>Latest</span>
    </a>

    <a href="<?=site_url('admin/dashboard/review/posts')?>"
        data-match="admin/dashboard/review/posts, admin/dashboard/review/pages"
        class="dash-sidenav__item">
        <svg class="svg-icon" aria-hidden="true">
            <use href="#eye"></use>
        </svg>
        <span>Review</span>
    </a>

    <a href="<?=site_url('admin/dashboard/logs/cron')?>"
        data-match="admin/dashboard/logs/cron, admin/dashboard/logs/hits, admin/dashboard/logs/error"
        class="dash-sidenav__item">
        <svg class="svg-icon" aria-hidden="true">
            <use href="#bug"></use>
        </svg>
        <span>Logs</span>
    </a>

    <a href="<?= site_url('admin/dashboard/trash/photos') ?>"
        data-match="
            admin/dashboard/trash/photos,
            admin/dashboard/trash/content,
            admin/dashboard/trash/accounts"
        class="dash-sidenav__item">
        <svg class="svg-icon" aria-hidden="true">
            <use href="#delete"></use>
        </svg>
        <span>Trash</span>
    </a>

    <div class="dash-sidenav__spacer"></div>

    <a href="<?= site_url('admin/dashboard/info/overview') ?>"
        data-match="
            admin/dashboard/info/overview,
            admin/dashboard/info/environment,
            admin/dashboard/info/session"
        class="dash-sidenav__item">
        <svg class="svg-icon" aria-hidden="true">
            <use href="#info-simple""></use>
        </svg>
        <span>Info</span>
    </a>
</nav>