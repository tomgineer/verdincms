<?= $this->extend('frontend/layouts/default') ?>
<?= $this->section('main') ?>

<div class="xl:container mx-2 xl:mx-auto px-4 mt-8 lg:mt-12 xl:mt-24 mb-0 lg:mb-12">
    <div class="flex flex-col lg:flex-row lg:gap-8">
        <section class="flex-1">
            <?= view('frontend/partials/post_list', ['posts' => $topPosts]) ?>
        </section>

        <aside class="w-full lg:w-[30%] hidden lg:block">
            <h2 class="text-3xl text-primary mt-8 mb-2"><?=lang('App.trending')?></h2>
            <?=view_cell('FrontendCell::trending')?>
        </aside>
    </div>
</div>

<?=view_cell('FrontendCell::featuredBlock')?>

<div class="xl:container mx-auto px-4 mt-0 lg:mt-30 mb-12 lg:mb-24">
    <div class="flex flex-col lg:flex-row gap-8">
        <section class="flex-1">
            <?= view('frontend/partials/post_list', ['posts' => $restPosts]) ?>
            <?= view('frontend/partials/pagination', ['pagination' => $pagination]) ?>
        </section>

        <aside class="w-full lg:w-[30%] lg:hidden">
            <h2 class="text-3xl text-primary mt-8 mb-2"><?=lang('App.trending')?></h2>
            <?=view_cell('FrontendCell::trending')?>
        </aside>

        <aside class="w-full lg:w-[30%]">
            <h2 class="text-3xl text-primary mt-8 mb-2"><?=lang('App.popular')?></h2>
            <?=view_cell('FrontendCell::popular')?>
        </aside>
    </div>

    <?php if (setting('theme.humanContent')): ?>
        <?= $this->include('frontend/partials/not_ai_badge') ?>
    <?php endif; ?>
</div>

<?php if (setting('theme.newsletter')): ?>
    <?=view_cell('FrontendCell::newsletterBlock')?>
<?php endif; ?>

<?= $this->endSection() ?>
