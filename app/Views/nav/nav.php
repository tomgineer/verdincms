<nav class="main-nav">

    <div class="main-nav__logo">
        <a href="<?=base_url()?>" title="← Back to the homepage">
            <picture>
                <source srcset="<?=path_gfx().'logo.svg'?>" media="(min-width: 1200px)">
                <img src="<?=path_gfx().'logo_icon.svg'?>" alt="Logo">
            </picture>
        </a>
    </div>

    <div class="main-nav__menu">
        <ul class="main-nav__list">

            <?php if( tier() >= 9 ):?>
                <li class="main-nav__nav-item hidden">
                    <a class="main-nav__nav-link" href="<?=site_url('admin/moderate/drafts')?>">Drafts</a>
                </li>
                <li class="main-nav__nav-item hidden">
                    <a class="main-nav__nav-link" href="<?=site_url('admin/moderate/review')?>">Review</a>
                </li>
            <?php endif;?>

            <li class="main-nav__nav-item hidden">
                <a class="main-nav__nav-link" href="<?=site_url('featured')?>">Featured</a>
            </li>
            <li class="main-nav__nav-item hidden">
                <a class="main-nav__nav-link" href="<?=site_url('ranking/trending')?>">Trending</a>
            </li>
            <li class="main-nav__nav-item hidden">
                <a class="main-nav__nav-link" href="<?=site_url('ranking/popular')?>">Popular</a>
            </li>

            <?php foreach ($menu_items['topics'] as $topic):?>
                <li class="main-nav__nav-item hidden">
                    <a class="main-nav__nav-link" href="<?=site_url('topic/' . $topic['slug'])?>"><?=esc($topic['title'])?></a>
                </li>
            <?php endforeach;?>

            <?php foreach ($menu_items['pages'] as $page):?>
                <li class="main-nav__nav-item hidden">
                    <a class="main-nav__nav-link" href="<?=site_url($page['s_slug'] . '/' . $page['slug'])?>"><?=esc($page['label'])?></a>
                </li>
            <?php endforeach;?>

            <?php if( tier() >= 10 ):?>
                <li class="main-nav__nav-item hidden">
                    <a class="main-nav__nav-link" href="<?=site_url('admin/mobile-analytics')?>">Mobile Analytics</a>
                </li>
            <?php endif;?>

            <li class="main-nav__nav-item">
                <button class="main-nav__nav-link main-nav__nav-more" type="button" aria-expanded="false">
                    <span>More</span>
                    <svg class="svg-icon svg-icon-lg" aria-hidden="true">
                        <use href="#tomsnews"></use>
                    </svg>
                </button>
            </li>
        </ul>
    </div>

    <div class="main-nav__search">
        <input class="main-nav__search-input" type="search" placeholder="Search articles...">
    </div>

    <div class="main-nav__toggle">
        <div class="theme-toggle">
            <svg class="svg-icon svg-icon-md" aria-hidden="true">
                <use href="#light-mode"></use>
            </svg>

            <label class="switch">
                <input type="checkbox" id="themeToggle">
                <span class="slider round"></span>
            </label>
        </div>
    </div>

    <div class="main-nav__quickjump">
        <?= $this->include('nav/quickjump') ?>
    </div>

</nav>

<nav class="secondary-nav hidden">
    <ul class="secondary-nav__list">
    </ul>
</nav>

<section class="search-results hidden">
    <ul class="plain-list plain-list--columns">
    </ul>
</section>