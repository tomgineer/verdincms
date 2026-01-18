<?= $this->extend('frontend/layouts/layout_home') ?>

<?= $this->section('hero') ?>
    <?php if (setting('cells.hero')): ?>
        <?= view_cell('FrontendCell::hero') ?>
    <?php endif; ?>
<?= $this->endSection() ?>

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
    <?php if (empty($pageNo) || (int) $pageNo === 1): ?>
        <?= view_cell('FrontendCell::featuredCarousel') ?>
        <?php if (setting('cells.testimonials')): ?>
            <?= view_cell('FrontendCell::testimonials') ?>
        <?php endif; ?>
    <?php endif; ?>
<?= $this->endSection() ?>

<?= $this->section('main_bottom') ?>
    <?= view('frontend/partials/post_list', ['posts' => $restPosts]) ?>
    <?= view('frontend/partials/pagination', ['pagination' => $pagination]) ?>
<?= $this->endSection() ?>

<?= $this->section('sidebar_bottom') ?>
    <div class="lg:hidden">
        <h2 class="text-3xl text-primary mt-8 mb-2"><?= lang('App.trending') ?></h2>
        <?= view_cell('FrontendCell::trending') ?>
    </div>
    <div>
        <h2 class="text-3xl text-primary mt-8 mb-2"><?= lang('App.popular') ?></h2>
        <?= view_cell('FrontendCell::popular') ?>
    </div>
<?= $this->endSection() ?>

<?= $this->section('call_to_action') ?>
    <?php if (setting('cells.humanContent')): ?>
        <?= $this->include('frontend/cells/not_ai') ?>
    <?php endif; ?>

    <?php if (setting('cells.newsletter')): ?>
        <?= view_cell('FrontendCell::newsletter') ?>
    <?php endif; ?>
<?= $this->endSection() ?>

<?= $this->section('footer') ?>
    <?= view_cell('FrontendCell::footer') ?>
<?= $this->endSection() ?>
