<nav class="navbar bg-base-200 shadow-sm z-999 mb-16">
    <div class="navbar-start">

        <div class="dropdown">
            <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" /> </svg>
            </div>

            <ul tabindex="0" class="menu menu-sm dropdown-content bg-base-300 rounded-box z-1 mt-3 w-70 p-2 shadow">
                <li>
                    <a>Item 1</a>
                </li>

                <li>
                    <a>Parent</a>
                    <ul class="p-2">
                        <li><a>Submenu 1</a></li>
                        <li><a>Submenu 2</a></li>
                    </ul>
                </li>

                <li>
                    <a>Item 3</a>
                </li>
            </ul>
        </div>

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
                        <?php foreach ($menu_items['pages'] as $page):?>
                            <li>
                                <a href="<?=site_url($page['s_slug'] . '/' . $page['slug'])?>"><?=esc($page['label'])?></a>
                            </li>
                        <?php endforeach;?>
                    </ul>
                </details>
            </li>

            <li>
                <details>
                    <summary>Administration</summary>
                    <ul class="p-2 bg-base-300 z-998 w-70">

                        <!--</?php if( tier() >= 9 ):?>-->
                            <li><a class="btn btn-soft btn-secondary mb-2" href="#">New Post</a></li>
                            <li><a class="btn btn-soft btn-primary mb-2" href="#">New Page</a></li>
                            <li><a href="<?=site_url('admin/moderate/drafts')?>">Drafts</a></li>
                        <!--</?php endif;?>-->

                        <!--</?php if( tier() >= 10 ):?>-->
                            <li><a href="<?=site_url('admin/moderate/review')?>">Review Pending</a></li>
                            <li><a href="#">Dashboard</a></li>
                            <li><a href="#">Analytics</a></li>
                            <li><a href="<?=site_url('admin/mobile-analytics')?>">Mobile Analytics</a></li>
                        <!--</?php endif;?>-->

                    </ul>
                </details>
            </li>

            <li><a>About</a></li>
            <li><a>Contact</a></li>
        </ul>
    </div>

    <div class="navbar-end flex gap-2">
        <a class="btn btn-accent btn-outline">Edit</a>
        <a class="btn btn-secondary">Login</a>
    </div>
</nav>
