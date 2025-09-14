<nav class="navbar bg-base-200 shadow-sm relative z-999">
    <div class="navbar-start">
        <?= $this->include('navbar/mobile_menu') ?>
        <a class="btn btn-ghost px-0 sm:px-4" href="<?=base_url()?>">
            <img class="h-full w-auto" src="<?=path_gfx().'logo.svg'?>" alt="Logo">
        </a>
    </div>

    <div class="navbar-center hidden lg:flex">
        <ul class="menu menu-horizontal px-1">

            <li>
                <details>
                    <summary>Ranking</summary>
                    <ul class="p-2 bg-base-300 z-998 w-70">
                        <li><a href="<?=site_url('ranking/trending')?>">Trending</a></li>
                        <li><a href="<?=site_url('ranking/popular')?>">Popular</a></li>
                        <li><a href="<?=site_url('featured')?>">Featured</a></li>
                    </ul>
                </details>
            </li>

            <li>
                <details>
                    <summary>Sections</summary>
                    <ul class="p-2 bg-base-300 z-998 w-70">
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
                    <ul class="p-2 bg-base-300 z-998 w-70">
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
                        <ul class="p-2 bg-base-300 z-998 w-70">
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
    </div>

    <div class="navbar-end flex gap-2">
        <?php if ($can_edit ?? false): ?>
            <?php if ( !empty($post) ):?>
                <a class="btn btn-primary" href="<?=site_url('admin/edit/post/'.$post['id'])?>">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                    </svg>
                    Edit
                </a>
            <?php elseif( !empty($page) ):?>
                <a class="btn btn-primary" href="<?=site_url('admin/edit/page/'.$page['id'])?>">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                    </svg>
                    Edit
                </a>
            <?php endif;?>
        <?php endif;?>

        <?php if( tier() == 0 ):?>
            <a class="btn btn-secondary" href="<?=site_url('login')?>">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                </svg>
                Login
            </a>
        <?php else:?>
            <a class="btn btn-warning" href="<?=site_url('users/logout')?>">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                </svg>
                Logout
            </a>
        <?php endif;?>
    </div>

</nav>


