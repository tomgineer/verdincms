<?php if( tier() >= 9 ):?>
    <a class="main-nav__quickjump-link hide-sm" href="<?=site_url('admin/edit/post/new')?>" data-match="admin/edit/post/new" aria-label="New Post" title="New Post">
        <svg class="svg-icon svg-icon-lg" aria-hidden="true">
            <use href="<?=svg('add')?>"></use>
        </svg>
    </a>
<?php endif;?>

<?php if( tier() >= 10 ):?>
    <a class="main-nav__quickjump-link hide-sm" href="<?=site_url('admin/edit/page/new')?>" data-match="admin/edit/page/new" aria-label="New Page" title="New Page">
        <svg class="svg-icon svg-icon-lg" aria-hidden="true">
            <use href="<?=svg('add-page')?>"></use>
        </svg>
    </a>

    <a class="main-nav__quickjump-link hide-sm" href="<?=site_url('admin/analytics')?>" data-match="admin/analytics" aria-label="Analytics" title="Analytics">
        <svg class="svg-icon svg-icon-lg" aria-hidden="true">
            <use href="<?=svg('bars')?>"></use>
        </svg>
    </a>

    <a class="main-nav__quickjump-link hide-sm" href="<?=site_url('admin/dashboard')?>" data-match="admin/dashboard" aria-label="Dashboard" title="Dashboard">
        <svg class="svg-icon svg-icon-lg" aria-hidden="true">
            <use href="<?=svg('dashboard')?>"></use>
        </svg>
    </a>

<?php endif;?>

<?php if ($can_edit ?? false): ?>
    <?php if ( !empty($post) ):?>
        <a class="main-nav__quickjump-link main-nav__quickjump-link--raised" href="<?=site_url('admin/edit/post/'.$post['id'])?>">
            <svg class="svg-icon svg-icon-lg" aria-hidden="true">
                <use href="<?=svg("ink-pen")?>"></use>
            </svg>
        </a>
    <?php elseif( !empty($page) ):?>
        <a class="main-nav__quickjump-link main-nav__quickjump-link--raised" href="<?=site_url('admin/edit/page/'.$page['id'])?>">
            <svg class="svg-icon svg-icon-lg" aria-hidden="true">
                <use href="<?=svg("ink-pen")?>"></use>
            </svg>
        </a>
    <?php endif;?>
<?php endif;?>

<?php if( tier() == 0 ):?>
    <a class="main-nav__quickjump-link" href="<?=site_url('login')?>" data-match="login" aria-label="Login" title="Login">
        <svg class="svg-icon svg-icon-lg" aria-hidden="true">
            <use href="<?=svg('login')?>"></use>
        </svg>
    </a>
<?php else:?>
    <a class="main-nav__quickjump-link main-nav__quickjump-link--logout" href="<?=site_url('users/logout')?>" aria-label="Logout" title="Logout">
        <svg class="svg-icon svg-icon-lg" aria-hidden="true">
            <use href="<?=svg('logout')?>"></use>
        </svg>
    </a>
<?php endif;?>