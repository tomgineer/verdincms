<?= $this->extend('layout_admin3') ?>
<?= $this->section('head') ?>
    <?php if ( !empty($useChartJS) ):?>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <?php endif;?>

    <?php if ( !empty($useCKEditor) ):?>
        <script src="<?=path_assets()?>ckeditor/ckeditor_lite.js?v=<?=setting('system.version')?>"></script>
        <link rel="stylesheet" href="<?=path_assets()?>ckeditor/ckeditor.css?v=<?=setting('system.version')?>">
    <?php endif;?>
<?= $this->endSection() ?>

<?= $this->section('main') ?>

<aside>
    <?= $this->include('dashboard/menu') ?>
</aside>

<main class="pl-24 pb-32 container mx-auto">
    <?php if ( !empty($path) ):?>
        <?= $this->include('dashboard/pages/' . $path) ?>
    <?php endif;?>
</main>

<?= $this->endSection() ?>