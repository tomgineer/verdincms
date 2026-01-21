<?= $this->extend('admin/layouts/layout_bare') ?>
<?= $this->section('main') ?>

<div class="container mx-auto px-4 mt-8 lg:mt-18 mb-12 lg:mb-24">
    <?php
        $items = $content_type === 'pages'
            ? ($content_data['pages'] ?? [])
            : ($content_data['posts'] ?? []);
    ?>
    <div class="flex flex-col lg:flex-row gap-8">

        <section class="flex-1">
            <h1 class="text-4xl text-base-content/70 mb-8 text-shadow-lg"><?= esc($site_title) ?></h1>
            <?php if ($content_type === 'pages'): ?>
                <?= view('admin/pages/moderate/pages_list', ['pages' => $items]) ?>
            <?php else: ?>
                <?= view('frontend/partials/post_list', ['posts' => $items]) ?>
            <?php endif; ?>
            <?= isset($content_data['pagination']) ? view('frontend/partials/pagination', ['pagination' => $content_data['pagination']]) : '' ?>
        </section>

        <aside class="w-full lg:w-[30%]">
            <?= view_cell('AdminCell::stats', ['statsType' => $stats_type, 'contentType' => $content_type]) ?>
        </aside>

    </div>
</div>

<?= $this->endSection() ?>
