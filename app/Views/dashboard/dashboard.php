<?= $this->extend('layout_admin') ?>
<?= $this->section('head') ?>
    <?php if ( !empty($useChartJS) ):?>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <?php endif;?>

    <?php if ( !empty($useCKEditor) ):?>
        <script src="<?=path_assets()?>ckeditor/ckeditor_lite.js?v=<?=setting('version')?>"></script>
        <link rel="stylesheet" href="<?=path_assets()?>ckeditor/ckeditor.css?v=<?=setting('version')?>">
    <?php endif;?>
<?= $this->endSection() ?>

<?= $this->section('main') ?>

<header class="dash-header">
    <?= $this->include('dashboard/components/header') ?>
</header>

<aside class="dash-aside">
    <?= $this->include('dashboard/components/sidenav') ?>
</aside>

<main class="dash-main">
    <div class="container container--3xl">
        <?php if ( !empty($path) ):?>
            <?= $this->include('dashboard/pages/' . $path) ?>
        <?php endif;?>
    </div>
</main>

<?= $this->endSection() ?>