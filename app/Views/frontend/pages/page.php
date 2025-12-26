<?= $this->extend('frontend/layouts/default') ?>
<?= $this->section('main') ?>

<article class="mb-16 lg:mb-24">

    <?php if ($page['disable_hero'] == 0): ?>
        <div class="relative w-full h-[350px] xl:h-[40vh] flex items-center justify-center overflow-hidden">
            <h1 class="z-10 text-5xl font-bold text-white text-center text-shadow-lg">
                <?= esc($page['title']) ?>
            </h1>
            <picture class="absolute inset-0 z-0">
                <source srcset="<?= path_img() . esc($page['photo']) ?>.webp" media="(min-width: 1921px)">
                <img class="w-full h-full object-cover brightness-50" src="<?= path_img_tn() . esc($page['photo']) ?>.webp" alt="Post Photo">
            </picture>
        </div>

    <?php else: ?>
        <h1 class="w-full lg:max-w-5xl lg:mx-auto text-5xl leading-tight mt-8"><?= esc($page['title']) ?></h1>
    <?php endif; ?>

    <section class="container mx-auto px-4 lg:py-8 mt-4 lg:mt-12">
        <h2 class="w-full lg:max-w-5xl lg:mx-auto text-content text-3xl mt-8 leading-tight"><?= esc($page['subtitle']) ?></h2>

        <div class="w-full  lg:max-w-4xl mx-auto mt-4 lg:mt-8 leading-relaxed text-xl prose prose-neutral">
            <?= esc($page['body'], 'raw') ?>
        </div>
    </section>

</article>

<?php if (setting('theme.pageExtras')): ?>
    <section class="container mx-auto px-4 mb-8">
        <h2 class="text-3xl mb-4 text-primary">Featured</h2>
        <?= view_cell('FrontendCell::featured', ['gridStyle' => 'columns']) ?>
    </section>

    <section class="container mx-auto px-4 mb-24 lg:mb-36">
        <h2 class="text-3xl mb-4 text-primary">Trending</h2>
        <?= view_cell('FrontendCell::trending', ['gridStyle' => 'columns']) ?>
    </section>
<?php endif; ?>

<?php if (setting('theme.pageBadges') && $page['slug'] === 'about'): ?>
    <?= $this->include('frontend/partials/badges') ?>
<?php endif; ?>

<?= $this->endSection() ?>