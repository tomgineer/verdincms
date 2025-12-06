<div class="navbar bg-base-300 z-999">
    <div class="flex-1">
        <a class="btn btn-ghost text-xl px-1 lg:px-4" href="<?= base_url() ?>">
            <img class="h-9 w-auto opacity-85 hover:opacity-100 transition-opacity duration-200 select-none" src="<?= path_gfx() . 'logo.svg' ?>" alt="Linkoreo Logo">
        </a>
    </div>

    <div class="flex items-center gap-2">
        <ul class="menu menu-horizontal leading-5 z-998">
            <li>
                <a href="" class="gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 text-info">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <span>New Post</span>
                </a>
            </li>

            <li>
                <details>
                    <summary>Ranking</summary>
                    <ul class="bg-base-200 rounded-t-none p-2 min-w-52">
                        <li><a href="<?=site_url('ranking/trending')?>">Trending</a></li>
                        <li><a href="<?=site_url('ranking/popular')?>">Popular</a></li>
                        <li><a href="<?=site_url('featured')?>">Featured</a></li>
                    </ul>
                </details>
            </li>

            <li>
                <details>
                    <summary>Sections</summary>
                    <ul class="bg-base-200 rounded-t-none p-2 min-w-52">
                        <?php foreach ($menu_items['topics'] as $topic):?>
                            <li>
                                <a href="<?=site_url('topic/' . $topic['slug'])?>"><?=esc($topic['title'])?></a>
                            </li>
                        <?php endforeach;?>
                    </ul>
                </details>
            </li>

            <li>
                <details>
                    <summary>The Blog</summary>
                    <ul class="bg-base-200 rounded-t-none p-2 min-w-52">
                        <?php foreach ($menu_items['pages'] as $page_items):?>
                            <li>
                                <a href="<?=site_url($page_items['s_slug'] . '/' . $page_items['slug'])?>"><?=esc($page_items['label'])?></a>
                            </li>
                        <?php endforeach;?>
                    </ul>
                </details>
            </li>

            <li><a href="<?=site_url('info/about')?>">About</a></li>
            <li><a href="<?=site_url('info/contact')?>">Contact</a></li>

            <?php if( tier() >= 9 ):?>
                <li>
                    <details>
                        <summary class="text-warning font-semibold">Administration</summary>
                        <ul class="bg-base-200 rounded-t-none p-2 min-w-52">
                            <li><a class="btn btn-success mb-2" href="<?=site_url('admin/edit/post/new')?>">New Post</a></li>
                            <li><a class="btn btn-soft mb-2" href="<?=site_url('admin/edit/page/new')?>">New Page</a></li>
                            <li><a href="<?=site_url('admin/moderate/drafts')?>">Drafts</a></li>

                            <?php if( tier() >= 10 ):?>
                                <li><a href="<?=site_url('admin/moderate/review')?>">Review Pending</a></li>
                                <li><a href="<?=site_url('admin/dashboard')?>">Dashboard</a></li>
                                <li><a href="<?=site_url('admin/analytics')?>">Analytics</a></li>
                            <?php endif;?>
                        </ul>
                    </details>
                </li>
            <?php endif;?>

        </ul>

        <input type="text" placeholder="Search" class="input input-bordered w-96 text-base hidden lg:flex" disabled />

        <div class="dropdown dropdown-end">
            <div tabindex="0" role="button" class="btn btn-ghost btn-square">
                <div class="h-full w-full flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                </div>
            </div>
            <ul

                tabindex="-1"
                class="menu menu-sm dropdown-content bg-base-200 rounded-box z-1 mt-3 w-52 p-2 shadow">
                <li>
                    <a class="justify-between">
                        Profile
                        <span class="badge">New</span>
                    </a>
                </li>
                <li><a>Settings</a></li>
                <li><a>Logout</a></li>
            </ul>
        </div>
    </div>
</div>