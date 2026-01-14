<?= $this->extend('frontend/layouts/layout_main') ?>

<?= $this->section('main_top') ?>
    <?= view('frontend/partials/post_list', ['posts' => $topPosts]) ?>
<?= $this->endSection() ?>

<?= $this->section('sidebar_top') ?>
    <div>
        <h2 class="text-3xl text-primary mt-8 mb-2"><?= lang('App.trending') ?></h2>
        <?= view_cell('FrontendCell::trending') ?>
    </div>
<?= $this->endSection() ?>

<?= $this->section('middle') ?>
    <?= view_cell('FrontendCell::featuredBlock') ?>
<?= $this->endSection() ?>

<?= $this->section('main_bottom') ?>
    <?= view('frontend/partials/post_list', ['posts' => $restPosts]) ?>
    <?= view('frontend/partials/pagination', ['pagination' => $pagination]) ?>
<?= $this->endSection() ?>

<?= $this->section('sidebar_bottom') ?>
    <div>
        <h2 class="text-3xl text-primary mt-8 mb-2"><?= lang('App.trending') ?></h2>
        <?= view_cell('FrontendCell::trending') ?>
    </div>
    <div>
        <h2 class="text-3xl text-primary mt-8 mb-2"><?= lang('App.popular') ?></h2>
        <?= view_cell('FrontendCell::popular') ?>
    </div>
<?= $this->endSection() ?>

<?= $this->section('bottom') ?>
    <?php if (setting('theme.humanContent')): ?>
        <?= $this->include('frontend/cells/not_ai') ?>
    <?php endif; ?>
<?= $this->endSection() ?>

<?= $this->section('call_to_action') ?>
    <?php if (setting('theme.newsletter')): ?>
        <?= view_cell('FrontendCell::newsletterBlock') ?>
    <?php endif; ?>
<?= $this->endSection() ?>
