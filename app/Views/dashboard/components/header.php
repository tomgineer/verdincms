<div class="dash-header-inline">
    <a href="<?=base_url()?>"><img class="dash-header-inline__logo" src="<?=path_gfx().'logo.svg'?>" alt="VerdinCMS Logo"></a>

    <div class="dash-header-inline__msg">
        <svg class="svg-icon svg-icon-lg color-blue-200" aria-hidden="true">
            <use href="#brain"></use>
        </svg>
        <span>You are currently rocking VerdinCMS v.<?=setting('system.version')?></span>
    </div>

    <nav class="dash-topnav">

        <button type="button" class="dash-topnav__btn">
            <svg class="svg-icon" aria-hidden="true">
                <use href="#search"></use>
            </svg>
        </button>

        <a href="<?=site_url('admin/analytics')?>" class="dash-topnav__btn">
            <svg class="svg-icon" aria-hidden="true">
                <use href="#bars"></use>
            </svg>
        </a>

        <button type="button" class="dash-topnav__btn">
            <svg class="svg-icon" aria-hidden="true">
                <use href="#bell"></use>
            </svg>
        </button>

        <button type="button" class="dash-topnav__btn">
            <img src="<?=path_avatar() . session('avatar') . '.webp'?>" alt="Profile Picture">
        </button>

    </nav>

</div>
