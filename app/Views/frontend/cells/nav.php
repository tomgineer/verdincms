<nav class="navbar bg-base-300 z-999" data-theme="<?=isAdmin()?'dark':setting('theme.darkBlocks')?>">
    <div class="flex-1 flex items-center gap-2">
        <a class="btn btn-ghost text-xl px-1 lg:px-4" href="<?= base_url() ?>">
            <img
                style="height: <?= (int) setting('theme.logoHeight') ?>px;"
                class="w-auto opacity-85 hover:opacity-100 transition-opacity duration-200 select-none"
                src="<?= path_gfx() . 'logo.svg' ?>"
                alt="Logo"
                data-logo>
        </a>

        <!-- Dashboard & Analytics Quick Access -->
        <?php if (tier() >= 10): ?>
            <ul class="flex gap-1 z-998">
                <li>
                    <a class="btn btn-sm btn-square hover:btn-info" href="<?= site_url('admin/analytics') ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                        </svg>
                    </a>
                </li>

                <li>
                    <a class="btn btn-sm btn-square hover:btn-info" href="<?= site_url('admin/dashboard') ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0V12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 12V5.25" />
                        </svg>
                    </a>
                </li>
            </ul>
        <?php endif; ?>

        <!-- Admin -->
        <?=$this->include('admin/partials/nav_admin')?>
    </div>

    <div class="flex items-center gap-2">
        <ul class="menu menu-horizontal leading-5 z-998">
            <!-- Topics -->
            <?php if (setting('navbar.displayTopics')): ?>
                <li class="hidden <?= (tier() != 0 ? '2xl:flex' : 'lg:flex') ?>">
                    <details>
                        <summary><?= lang('App.topics') ?></summary>
                        <ul class="bg-base-200 rounded-t-none p-2 min-w-52 shadow-xl">
                            <?php foreach ($menu_items['topics'] as $topic): ?>
                                <li>
                                    <a href="<?= site_url('topic/' . $topic['slug']) ?>"><?= esc($topic['title']) ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </details>
                </li>
            <?php endif; ?>

            <!-- Ranking -->
            <?php if (setting('navbar.displayRanking')): ?>
                <li class="hidden <?= (tier() != 0 ? '2xl:flex' : 'lg:flex') ?>">
                    <details>
                        <summary><?= lang('App.ranking') ?></summary>
                        <ul class="bg-base-200 rounded-t-none p-2 min-w-52 shadow-xl">
                            <li><a href="<?= site_url('ranking/trending') ?>"><?= lang('App.trending') ?></a></li>
                            <li><a href="<?= site_url('ranking/popular') ?>"><?= lang('App.popular') ?></a></li>
                            <li><a href="<?= site_url('featured') ?>"><?= lang('App.featured') ?></a></li>
                        </ul>
                    </details>
                </li>
            <?php endif; ?>

            <!-- Blog -->
            <?php if (setting('navbar.displayBlog')): ?>
                <li class="hidden lg:flex">
                    <details>
                        <summary><?= setting('theme.pagesLabel') ?></summary>
                        <ul class="bg-base-200 rounded-t-none p-2 min-w-52 shadow-xl">
                            <?php foreach ($menu_items['pages'] as $page_items): ?>
                                <li>
                                    <a href="<?= site_url($page_items['s_slug'] . '/' . $page_items['slug']) ?>"><?= esc($page_items['label']) ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </details>
                </li>
            <?php endif; ?>

            <?php if (setting('navbar.displayAbout')): ?>
                <li class="hidden lg:flex"><a href="<?= site_url('info/about') ?>"><?= lang('App.about') ?></a></li>
            <?php endif; ?>

            <?php if (setting('navbar.displayContact')): ?>
                <li class="hidden lg:flex"><a href="<?= site_url('info/contact') ?>"><?= lang('App.contact') ?></a></li>
            <?php endif; ?>
        </ul>

        <!-- Search -->
        <?php if (setting('navbar.displaySearch') && !isAdmin()): ?>
            <input
                type="search"
                placeholder="<?= lang('App.search') ?>"
                class="input input-bordered w-[15vw] text-base hidden lg:flex focus:border-none focus:outline-primary"
                data-js-search />
            <section class="hidden absolute top-16 left-1/2 -translate-x-1/2 z-900 max-w-6xl w-full bg-base-300 rounded-2xl shadow-2xl p-8 border-2 border-primary" data-js-search-results>No Results..</section>
        <?php endif; ?>

        <!-- Theme Switcher -->
        <?php if (setting('navbar.themeSwitcher') && !isAdmin()): ?>
            <label class="flex items-center cursor-pointer gap-2 mx-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="5" />
                    <path d="M12 1v2M12 21v2M4.2 4.2l1.4 1.4M18.4 18.4l1.4 1.4M1 12h2M21 12h2M4.2 19.8l1.4-1.4M18.4 5.6l1.4-1.4" />
                </svg>

                <input type="checkbox" class="toggle theme-controller" value="<?= setting('theme.main') ?>" aria-label="Toggle dark mode" />

                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                </svg>
            </label>
        <?php endif; ?>

        <!-- Sign in / out -->
        <?php if (tier() === 0): ?>
            <a class="btn btn-outline border-base-content/70 hover:btn-primary hover:border-primary hidden lg:flex"
                href="<?= site_url('login') ?>">
                Sign in
            </a>
        <?php else: ?>
            <a class="btn btn-outline border-base-content/70 hover:btn-secondary hover:border-secondary hidden lg:flex"
                href="<?= site_url('users/logout') ?>">
                Sign out
            </a>
        <?php endif; ?>

        <!-- Edit Buttons -->
        <?php if ($can_edit ?? false): ?>
            <?php if (!empty($post)): ?>
                <a class="btn btn-primary" href="<?= site_url('admin/edit/post/' . $post['id']) ?>">Edit</a>
            <?php elseif (!empty($page)): ?>
                <a class="btn btn-primary" href="<?= site_url('admin/edit/page/' . $page['id']) ?>">Edit</a>
            <?php endif; ?>
        <?php endif; ?>

    </div>
</nav>
