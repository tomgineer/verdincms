<?= $this->extend('frontend/layouts/default') ?>
<?= $this->section('main') ?>

<?php
    $latestPosts = $latest_updates['posts'] ?? [];
    $halfCount = (int) ceil(count($latestPosts) / 2);
    $topPosts = array_slice($latestPosts, 0, $halfCount);
    $restPosts = array_slice($latestPosts, $halfCount);
?>

<div class="container mx-auto px-4 mt-12 lg:mt-24 mb-8 lg:mb-12">
    <div class="flex flex-col lg:flex-row gap-8">
        <section class="flex-1">
            <?= view('frontend/partials/post_list', ['posts' => $topPosts]) ?>
        </section>

        <aside class="w-full lg:w-[30%]">
            <h2 class="text-3xl text-primary mt-8 mb-2">Trending</h2>
            <?=view_cell('FrontendCell::trending')?>
        </aside>
    </div>
</div>

<?=view_cell('FrontendCell::featuredBlock')?>

<div class="container mx-auto px-4 mt-16 lg:mt-30 mb-12 lg:mb-24">
    <div class="flex flex-col lg:flex-row gap-8">
        <section class="flex-1">
            <?= view('frontend/partials/post_list', ['posts' => $restPosts]) ?>
            <?= view('frontend/partials/pagination', ['pagination' => $latest_updates['pagination']]) ?>
        </section>

        <aside class="w-full lg:w-[30%]">
            <h2 class="text-3xl text-primary mt-8 mb-2">Popular</h2>
            <?=view_cell('FrontendCell::popular')?>
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
