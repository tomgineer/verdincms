<div class="navbar bg-base-300 z-999">
    <div class="flex-1 flex items-center gap-2">
        <a class="btn btn-ghost text-xl px-1 lg:px-4" href="<?= base_url() ?>">
            <img class="h-9 w-auto opacity-85 hover:opacity-100 transition-opacity duration-200 select-none" src="<?= path_gfx() . 'logo.svg' ?>" alt="Linkoreo Logo">
        </a>

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
    </div>

    <div class="flex items-center gap-2">
        <ul class="menu menu-horizontal leading-5 z-998">
            <?php if (tier() >= 9): ?>
                <li class="hidden lg:flex">
                    <a href="<?= site_url('admin/edit/post/new') ?>" class="gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 text-info">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        <span>New Post</span>
                    </a>
                </li>

                <li class="hidden lg:flex">
                    <details>
                        <summary>Administration</summary>
                        <ul class="bg-base-200 rounded-t-none p-2 min-w-52 shadow-xl">
                            <li>
                                <a href="<?= site_url('admin/edit/page/new') ?>" class="gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 text-info">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                    <span>New Page</span>
                                </a>
                            </li>

                            <li class="my-1 border-t border-base-content/30"></li>

                            <li><a href="<?= site_url('admin/moderate/drafts') ?>">Drafts</a></li>

                            <?php if (tier() >= 10): ?>
                                <li><a href="<?= site_url('admin/moderate/review') ?>">Review Pending</a></li>

                                <li class="my-1 border-t border-base-content/30"></li>

                                <li>
                                    <a href="<?= site_url('admin/dashboard') ?>" class="gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 text-info">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0V12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 12V5.25" />
                                        </svg>
                                        <span>Dashboard</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="<?= site_url('admin/analytics') ?>" class="gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 text-info">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                                        </svg>
                                        <span>Analytics</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </details>
                </li>
            <?php endif; ?>

            <li class="hidden lg:flex">
                <details>
                    <summary>Ranking</summary>
                    <ul class="bg-base-200 rounded-t-none p-2 min-w-52 shadow-xl">
                        <li><a href="<?= site_url('ranking/trending') ?>">Trending</a></li>
                        <li><a href="<?= site_url('ranking/popular') ?>">Popular</a></li>
                        <li><a href="<?= site_url('featured') ?>">Featured</a></li>
                    </ul>
                </details>
            </li>

            <li class="hidden lg:flex">
                <details>
                    <summary>Sections</summary>
                    <ul class="bg-base-200 rounded-t-none p-2 min-w-52 shadow-xl">
                        <?php foreach ($menu_items['topics'] as $topic): ?>
                            <li>
                                <a href="<?= site_url('topic/' . $topic['slug']) ?>"><?= esc($topic['title']) ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </details>
            </li>

            <li class="hidden lg:flex">
                <details>
                    <summary>The Blog</summary>
                    <ul class="bg-base-200 rounded-t-none p-2 min-w-52 shadow-xl">
                        <?php foreach ($menu_items['pages'] as $page_items): ?>
                            <li>
                                <a href="<?= site_url($page_items['s_slug'] . '/' . $page_items['slug']) ?>"><?= esc($page_items['label']) ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </details>
            </li>

            <li class="hidden lg:flex"><a href="<?= site_url('info/about') ?>">Περί</a></li>
            <li class="hidden lg:flex"><a href="<?= site_url('info/contact') ?>">Επικοινωνία</a></li>

        </ul>

        <input type="text" placeholder="Search" class="input input-bordered w-96 text-base hidden lg:flex" data-js-search />
        <section class="hidden fixed top-16 left-0 right-0 z-50 min-h-[calc(100vh-4rem)] bg-base-100 overflow-y-auto p-8" data-js-search-results>No Results..</section>

        <div class="dropdown dropdown-end">
            <div tabindex="0" role="button" class="btn btn-ghost btn-square text-base-content/45 lg:text-base-content">
                <div class="h-full w-full flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                </div>
            </div>
            <ul

                tabindex="-1"
                class="menu menu-sm dropdown-content bg-base-200 rounded-box z-1 mt-3 w-52 p-2 shadow-xl">
                <?php if (tier() == 0): ?>
                    <li>
                        <a href="<?= site_url('login') ?>" class="flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 text-accent">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                            </svg>
                            <span>Sign in</span>
                        </a>
                    </li>
                <?php else: ?>
                    <li>
                        <a href="<?= site_url('users/logout') ?>" class="flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 text-red-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                            </svg>

                            <span>Sign out</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>