<?= $this->extend('admin/layouts/default') ?>
<?= $this->section('head') ?>
    <?php if ( !empty($useChartJS) ):?>
        <script src="<?= base_url('js/chart.js') ?>"></script>
    <?php endif;?>

    <?php if ( !empty($useCKEditor) ):?>
        <script src="<?=path_assets()?>ckeditor/ckeditor_lite.js?v=<?=setting('system.version')?>"></script>
        <link rel="stylesheet" href="<?=path_assets()?>ckeditor/ckeditor.css?v=<?=setting('system.version')?>">
    <?php endif;?>
<?= $this->endSection() ?>

<?= $this->section('main') ?>

<aside>
    <?= $this->include('admin/dashboard/menu') ?>
</aside>

<main class="pl-24 pb-32 container mx-auto">
    <?php if ( !empty($path) ):?>
        <?= $this->include('admin/dashboard/pages/' . $path) ?>
    <?php endif;?>
</main>

<?= $this->endSection() ?>
