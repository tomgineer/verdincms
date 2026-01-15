<section class="footer footer-horizontal footer-center text-base-content rounded p-10 pt-12 relative bg-base-200" data-theme="<?=setting('theme.darkBlocks')?>">
    <a class="btn btn-lg btn-circle btn-soft absolute left-1/2 -translate-x-1/2 -top-6 shadow-md" href="#">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5 12 3m0 0 7.5 7.5M12 3v18" />
        </svg>
    </a>

    <nav class="flex flex-wrap gap-1 justify-center">
        <?php foreach ($topics_list as $topic): ?>
            <a class="btn btn-soft hover:btn-accent" href="<?= site_url('topic/' . $topic['slug']) ?>" data-match="<?= 'topic/' . $topic['slug'] ?>"><?= $topic['title'] ?></a>
        <?php endforeach; ?>
    </nav>
</section>

<section class="footer sm:footer-horizontal text-base-content p-10 pt-1 bg-base-200" data-theme="<?=setting('theme.darkBlocks')?>">

    <nav>
        <ul class="menu w-full">
            <li>
                <h2 class="menu-title text-lg"><?=lang('App.mini_stas')?></h2>
                <ul>
                    <li><div><?=lang('App.public_posts')?>: <span class="text-accent"><?= esc($public_posts) ?></span></div></li>
                    <li class="hidden"><div><?=lang('App.subscribers')?>: <span class="text-accent"><?= esc($total_subscribers) ?></span></div></li>
                    <li><div><?=lang('App.cms_version')?>: <span class="text-accent"><?= VERDINCMS_VERSION ?></span></div></li>
                    <li><div>Rendered in: <span class="text-accent">{elapsed_time} sec</span></div></li>
                </ul>
            </li>
        </ul>
    </nav>

    <?php foreach ($pages_list as $sectionName => $pages): ?>
        <nav>
            <ul class="menu w-full">
                <li>
                    <h2 class="menu-title text-lg"><?= $sectionName ?></h2>
                    <ul>
                        <?php foreach ($pages as $page): ?>
                            <?php if (empty($page['url'])): ?>
                                <li><a href="<?= site_url($page['s_slug'] . '/' . $page['slug']) ?>" data-match="<?= $page['s_slug'] . '/' . $page['slug'] ?>"><?= $page['label'] ?></a></li>
                            <?php else: ?>
                                <li><a href="<?= $page['url'] ?>" data-match="<?= $page['slug'] ?>"><?= $page['label'] ?></a></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </li>
            </ul>
        </nav>
    <?php endforeach; ?>

</section>

<section class="footer text-base-content border-base-200 border-t-2 px-10 py-8 pb-8 lg:gap-0 bg-base-200" data-theme="<?=setting('theme.darkBlocks')?>">
    <aside class="grid-flow-row lg:grid-flow-col gap-6 items-center">
        <a href="<?= base_url() ?>">
            <img
                style="height: <?= ((int) setting('theme.logoHeight') * 1.5) ?>px;"
                class="w-auto"
                src="<?= path_gfx() . 'logo.svg' ?>"
                alt="Logo"
                data-logo>
        </a>
        <div class="text-base-content/70 [&_a]:underline">
            <?= block($base_blocks, 'footer', 'footer_copyright', 'body') ?>
        </div>
    </aside>

    <?php if (empty($socials_list)):?>
        <div class="place-self-center md:justify-self-end">
            <img class="h-15 w-auto opacity-65" src="<?=path_gfx().'no_socials.svg'?>" alt="No Social Media" loading="lazy">
        </div>
    <?php else:?>
        <nav class="place-self-center md:justify-self-end">
            <div class="grid grid-flow-col gap-4">
                <?php foreach ($socials_list as $social): ?>
                    <a
                        class="text-base-content/50 hover:text-accent transform transition-transform duration-200 hover:scale-125"
                        href="<?= esc($social['value']) ?>"
                        target="_blank"
                        rel="noopener noreferrer nofollow"
                        aria-label="<?= esc($social['label']) ?>"
                        title="<?= esc($social['label']) ?>">
                        <svg class="w-6 h-6 fill-current" aria-hidden="true" focusable="false">
                            <use href="<?= path_gfx() . 'icons.svg#icon-' . esc($social['icon_id']) ?>"></use>
                        </svg>
                    </a>
                <?php endforeach; ?>
            </div>
        </nav>
    <?php endif;?>
</section>
