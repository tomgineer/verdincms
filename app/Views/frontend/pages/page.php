<?= $this->extend('frontend/layouts/layout_single') ?>

<?= $this->section('hero') ?>
    <?php if ($page['disable_hero'] == 0): ?>
        <div class="relative w-full h-[350px] xl:h-[40vh] flex items-center justify-center overflow-hidden bg-black">
            <h1 class="z-10 text-5xl font-bold text-white text-center text-shadow-lg">
                <?= esc($page['title']) ?>
            </h1>
            <picture class="absolute inset-0 z-0">
                <source srcset="<?= base_url('images/') . esc($page['photo']) ?>.webp" media="(min-width: 1921px)">
                <img class="w-full h-full object-cover brightness-50" src="<?= base_url('images/tn/') . esc($page['photo']) ?>.webp" alt="Post Photo">
            </picture>
        </div>
    <?php else: ?>
        <div>
            <h1 class="w-full lg:max-w-5xl lg:mx-auto text-5xl leading-tight mt-8"><?= esc($page['title']) ?></h1>
        </div>
    <?php endif; ?>
<?= $this->endSection() ?>

<?= $this->section('main') ?>
    <article>
        <h2 class="w-full lg:max-w-5xl lg:mx-auto text-content text-3xl mt-8 leading-tight"><?= esc($page['subtitle']) ?></h2>

        <div class="w-full  lg:max-w-4xl mx-auto mt-4 lg:mt-8 leading-relaxed text-xl prose prose-neutral">
            <?= $page['body'] ?>
        </div>
    </article>
<?= $this->endSection() ?>

<?= $this->section('aside_top') ?>
    <?php if (setting('theme.pageExtras')): ?>
        <section>
            <h2 class="text-3xl lg:text-4xl mb-4 text-primary"><?=lang('App.featured')?></h2>
            <?= view_cell('FrontendCell::featured', ['gridStyle' => 'columns']) ?>
        </section>
    <?php endif; ?>
<?= $this->endSection() ?>

<?= $this->section('middle') ?>
    <?php if (setting('cells.newsletter')): ?>
        <?= view_cell('FrontendCell::newsletter') ?>
    <?php endif; ?>
<?= $this->endSection() ?>

<?= $this->section('aside_bottom') ?>
    <?php if (setting('theme.pageExtras')): ?>
        <section class="mb-12 lg:mb-24">
            <h2 class="text-3xl lg:text-4xl mb-4 text-primary"><?=lang('App.trending')?></h2>
            <?= view_cell('FrontendCell::trending', ['gridStyle' => 'columns']) ?>
        </section>
    <?php endif; ?>
<?= $this->endSection() ?>

<?= $this->section('footer') ?>
    <?= view_cell('FrontendCell::footer') ?>
<?= $this->endSection() ?>