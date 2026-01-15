<?= $this->extend('frontend/layouts/layout_archive') ?>

<?= $this->section('main') ?>
    <div class="mb-12 lg:mb-24">
        <h1 class="text-4xl text-base-content"><?= esc($site_title) ?></h1>
        <?php if (!empty($site_desc)): ?>
            <div class="prose prose-sm max-w-none mt-3 rounded-lg p-4 lg:p-6 bg-base-200">
                <?= $site_desc ?>
            </div>
        <?php endif; ?>
    </div>

    <div>
        <?= view('frontend/partials/post_list', ['posts' => $post_data['posts']]) ?>
        <?= isset($post_data['pagination']) ? view('frontend/partials/pagination', ['pagination' => $post_data['pagination']]) : '' ?>
    </div>
<?= $this->endSection() ?>

<?= $this->section('sidebar') ?>
    <?php if (empty($hideTrending)): ?>
        <div>
            <h2 class="text-3xl text-primary mt-8 mb-2">Trending</h2>
            <?= view_cell('FrontendCell::trending') ?>
        </div>
    <?php endif; ?>

    <?php if (empty($hidePopular)): ?>
        <div>
            <h2 class="text-3xl text-primary mt-8 mb-2">Featured</h2>
            <?= view_cell('FrontendCell::featured') ?>
        </div>
    <?php endif; ?>
<?= $this->endSection() ?>

<?= $this->section('footer') ?>
    <?= view_cell('FrontendCell::footer') ?>
<?= $this->endSection() ?>