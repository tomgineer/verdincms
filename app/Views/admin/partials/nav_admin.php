<?php if (tier() >= 9): ?>
    <ul class="menu menu-horizontal leading-5 z-998">
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
                <summary>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 text-info">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    <span>Admin</span>
                </summary>
                <ul class="bg-base-200 rounded-t-none p-2 min-w-52 shadow-xl">
                    <li>
                        <a href="<?= site_url('admin/edit/page/new') ?>" class="gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 text-info">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            <span>New Page</span>
                        </a>
                    </li>

                    <li class="my-1 border-t border-base-content"></li>

                    <li class="menu-title text-info"><span>Drafts</span></li>
                    <li>
                        <a class="ml-4" href="<?= site_url('admin/moderate/drafts/posts') ?>">Posts</a>
                    </li>
                    <li>
                        <a class="ml-4" href="<?= site_url('admin/moderate/drafts/pages') ?>">Pages</a>
                    </li>

                    <li class="my-1 border-t border-base-content"></li>

                    <?php if (tier() >= 10): ?>

                        <li class="menu-title text-info"><span>Review</span></li>

                        <li>
                            <a class="ml-4" href="<?= site_url('admin/moderate/review/posts') ?>">Posts</a>
                        </li>
                        <li>
                            <a class="ml-4" href="<?= site_url('admin/moderate/review/pages') ?>">Pages</a>
                        </li>

                        <li class="my-1 border-t border-base-content"></li>

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

        <?php if (tier() >= 10): ?>
            <li class="hidden lg:flex">
                <details>
                    <summary>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 text-info">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0V12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 12V5.25" />
                        </svg>
                        <span>Dashboard</span>
                    </summary>
                    <ul class="bg-base-200 rounded-t-none p-2 min-w-52 shadow-xl">
                        <?php if (tier() >= 10): ?>
                            <li><a href="<?= site_url('admin/dashboard/blocks/blocks') ?>">Blocks</a></li>
                            <li><a href="<?= site_url('admin/dashboard/subjects/subjects') ?>">Topics</a></li>
                            <li><a href="<?= site_url('admin/dashboard/trash/trash') ?>">Trash</a></li>
                            <li><a href="<?= site_url('admin/dashboard/accounts/accounts') ?>">Accounts</a></li>
                            <li><a href="<?= site_url('admin/dashboard/logs/logs') ?>">Logs</a></li>
                        <?php endif; ?>
                    </ul>
                </details>
            </li>
        <?php endif; ?>

        <li>
            <details>
                <summary>Pages</summary>
                <ul class="bg-base-200 rounded-t-none p-2 min-w-52 shadow-xl">
                    <?php foreach ($menu_items['all_pages'] as $page_items): ?>
                        <li>
                            <a href="<?= site_url($page_items['s_slug'] . '/' . $page_items['slug']) ?>"><?= esc($page_items['label']) ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </details>
        </li>

        <li>
            <details>
                <summary>Topics</summary>
                <ul class="bg-base-200 rounded-t-none p-2 min-w-52 shadow-xl">
                    <?php foreach ($menu_items['all_topics'] as $topic): ?>
                        <li>
                            <a href="<?= site_url('topic/' . $topic['slug']) ?>"><?= esc($topic['title']) ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </details>
        </li>

    </ul>
<?php endif; ?>