<nav class="navbar bg-base-200 shadow-sm z-999">
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
                <a class="btn btn-primary" href="<?=site_url('admin/edit/post/'.$post['id'])?>">Edit</a>
            <?php elseif( !empty($page) ):?>
                <a class="btn btn-primary" href="<?=site_url('admin/edit/page/'.$page['id'])?>">Edit</a>
            <?php endif;?>
        <?php endif;?>

        <?php if( tier() == 0 ):?>
            <a class="btn btn-secondary" href="<?=site_url('login')?>">Login</a>
        <?php else:?>
            <a class="btn btn-warning" href="<?=site_url('users/logout')?>">Logout</a>
        <?php endif;?>
    </div>

</nav>


