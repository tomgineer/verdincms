<section class="footer footer-horizontal footer-center text-base-content rounded p-10 pt-12 relative">
    <a class="btn btn-lg btn-circle btn-soft btn-primary absolute left-1/2 -translate-x-1/2 -top-6 shadow-md" href="#">
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

<section class="footer sm:footer-horizontal text-base-content p-10 pt-1">

    <nav class="text-base-content/70">
        <h4 class="text-xl text-neutral-content">Νουμεράκια</h4>
        <p>Σύνολο δημοσιεύσεων: <span class="text-accent font-semibold"><?= esc($total_posts) ?></span></p>
        <p>Δημόσια άρθρα: <span class="text-accent font-semibold"><?= esc($public_posts) ?></span></p>
        <p>Έκδοση CMS: <span class="text-accent font-semibold"><?= setting('system.version') ?></span></p>
        <p>Rendered in: <span class="text-accent font-semibold">{elapsed_time} sec</span></p>
    </nav>

    <?php foreach ($pages_list as $sectionName => $pages): ?>
        <nav>
            <h4 class="text-xl text-neutral-content"><?= $sectionName ?></h4>
            <?php foreach ($pages as $page): ?>
                <?php if (empty($page['url'])): ?>
                    <a class="link link-hover text-base-content/70" href="<?= site_url($page['s_slug'] . '/' . $page['slug']) ?>" data-match="<?= $page['s_slug'] . '/' . $page['slug'] ?>"><?= $page['label'] ?></a>
                <?php else: ?>
                    <a class="link link-hover text-base-content/70" href="<?= $page['url'] ?>" data-match="<?= $page['slug'] ?>"><?= $page['label'] ?></a>
                <?php endif; ?>
            <?php endforeach; ?>
        </nav>
    <?php endforeach; ?>

</section>

<section class="footer text-base-content border-base-200 border-t-2 px-10 py-8 pb-8">
    <aside class="grid-flow-col gap-6 items-center">
        <a href="<?= base_url() ?>">
            <img class="h-14" src="<?= path_gfx() . 'logo.svg' ?>" alt="Logo Color" loading="lazy">
        </a>
        <div class="text-base-content/70">
            <?= block($base_blocks, 'footer', 'footer_copyright', 'body') ?>
        </div>
    </aside>

    <nav class="md:place-self-center md:justify-self-end">
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

</section>