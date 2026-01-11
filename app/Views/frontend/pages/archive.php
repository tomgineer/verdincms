<?= $this->extend('frontend/layouts/default') ?>
<?= $this->section('main') ?>

<div class="container mx-auto px-4 mt-8 lg:mt-18 mb-12 lg:mb-24">
    <div class="flex flex-col lg:flex-row gap-8">

        <section class="flex-1">
            <header class="mb-8 lg:mb-12">
                <h1 class="text-4xl text-base-content text-shadow-lg"><?= esc($site_title) ?></h1>
                <?php if (!empty($site_desc)): ?>
                    <div class="prose prose-sm max-w-none mt-3 rounded-lg p-4 lg:p-6 bg-base-200 dark:bg-black/20">
                        <?=$site_desc?>
                    </div>
                <?php endif; ?>
            </header>
            <?= view('frontend/partials/post_list', ['posts' => $post_data['posts']]) ?>
            <?= isset($post_data['pagination']) ? view('frontend/partials/pagination', ['pagination' => $post_data['pagination']]) : '' ?>
        </section>

        <aside class="w-full lg:w-[30%]">

            <?php if (empty($hideTrending)): ?>
                <h2 class="text-3xl text-primary mt-8 mb-2">Trending</h2>
                <?= view_cell('FrontendCell::trending') ?>
            <?php endif; ?>

            <?php if (empty($hidePopular)): ?>
                <h2 class="text-3xl text-primary mt-8 mb-2">Featured</h2>
                <?= view_cell('FrontendCell::featured') ?>
            <?php endif; ?>

        </aside>

    </div>
</div>

<?= $this->endSection() ?>
