<div class="dropdown">
    <!-- trigger -->
    <div tabindex="0" role="button" class="btn btn-ghost lg:hidden" aria-label="Open menu">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 6h16M4 12h8m-8 6h16" />
        </svg>
    </div>

    <!-- content -->
    <ul tabindex="0" class="menu dropdown-content bg-base-300 rounded-box z-1 mt-3 w-70 p-2 shadow">
        <li>
            <details>
                <summary>Ranking</summary>
                <ul class="p-2">
                    <li><a href="<?=site_url('ranking/trending')?>">Trending</a></li>
                    <li><a href="<?=site_url('ranking/popular')?>">Popular</a></li>
                    <li><a href="<?=site_url('featured')?>">Featured</a></li>
                </ul>
            </details>
        </li>

        <li>
            <details>
                <summary>Sections</summary>
                <ul class="p-2">
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
                <ul class="p-2">
                    <?php foreach ($menu_items['pages'] as $page):?>
                        <li>
                            <a href="<?=site_url($page['s_slug'] . '/' . $page['slug'])?>"><?=esc($page['label'])?></a>
                        </li>
                    <?php endforeach;?>
                </ul>
            </details>
        </li>

        <?php if( tier() >= 9 ):?>
            <li>
                <details>
                    <summary class="text-warning font-semibold">Administration</summary>
                    <ul class="p-2">
                        <li><a class="btn btn-success mb-2" href="<?=site_url('admin/edit/page/new')?>">New Post</a></li>
                        <li><a class="btn btn-soft mb-2" href="<?=site_url('admin/edit/page/new')?>">New Page</a></li>
                        <li><a href="<?=site_url('admin/moderate/drafts')?>">Drafts</a></li>

                        <?php if( tier() >= 10 ):?>
                            <li><a href="<?=site_url('admin/moderate/review')?>">Review Pending</a></li>
                            <li><a href="<?=site_url('admin/dashboard')?>">Dashboard</a></li>
                            <li><a href="<?=site_url('admin/analytics')?>">Analytics</a></li>
                            <li><a href="<?=site_url('admin/mobile-analytics')?>">Mobile Analytics</a></li>
                        <?php endif;?>
                    </ul>
                </details>
            </li>
        <?php endif;?>

        <li><a href="<?=site_url('info/about')?>">About</a></li>
        <li><a href="<?=site_url('info/contact')?>">Contact</a></li>
    </ul>
</div>
