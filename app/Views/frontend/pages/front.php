<?= $this->extend('frontend/layouts/default') ?>
<?= $this->section('main') ?>

<div class="container mx-auto px-4 mt-8 lg:mt-18 mb-12 lg:mb-24">
    <div class="flex flex-col lg:flex-row gap-8">

        <section class="flex-1">
            <?= view('frontend/partials/post_list', ['posts' => $latest_updates['posts']]) ?>
            <?= view('frontend/partials/pagination', ['pagination' => $latest_updates['pagination']]) ?>
        </section>

        <aside class="w-full lg:w-[30%]">
            <div class="xl:sticky xl:top-8">
                <h2 class="text-3xl text-primary mt-8 mb-2">Featured</h2>
                <?=view_cell('FrontendCell::featured')?>

                <h2 class="text-3xl text-primary mt-8 mb-2">Trending</h2>
                <?=view_cell('FrontendCell::trending')?>

                <h2 class="text-3xl text-primary mt-8 mb-2">Popular</h2>
                <?=view_cell('FrontendCell::popular')?>
            </div>
        </aside>

    </div>

    <?php if (setting('theme.humanContent')): ?>
        <?= $this->include('frontend/partials/not_ai_badge') ?>
    <?php endif; ?>
</div>

<?php if (setting('theme.newsletter')): ?>
    <?= $this->include('frontend/partials/newsletter') ?>
<?php endif; ?>

<?= $this->endSection() ?>
