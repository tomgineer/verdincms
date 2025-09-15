<?= $this->extend('layout_admin') ?>
<?= $this->section('head') ?>
    <?php if ( !empty($useChartJS) ):?>
        <script src="<?= base_url('js/chart.js') ?>"></script>
    <?php endif;?>
<?= $this->endSection() ?>

<?= $this->section('main') ?>

<aside>
    <?= $this->include('analytics/menu') ?>
</aside>

<main class="pl-24 pb-32 container mx-auto">
    <?php if ( !empty($path) ):?>
        <?= $this->include('analytics/pages/' . $path) ?>
    <?php endif;?>
</main>

<?= $this->endSection() ?>