<?= $this->extend('layout_admin2') ?>
<?= $this->section('head') ?>

    <script src="<?=path_assets()?>ckeditor/ckeditor.js?v=<?=setting('system.version')?>"></script>
    <link rel="stylesheet" href="<?=path_assets()?>ckeditor/ckeditor.css?v=<?=setting('system.version')?>">

<?= $this->endSection() ?>

<?= $this->section('main') ?>

<aside class="edit-aside-left">
    <?= $this->include('edit/components/sidebar_left') ?>
</aside>

<main class="edit-main">
    <?= $this->include('edit/main') ?>
</main>

<aside>
    <?= $this->include('edit/sidebar') ?>
</aside>

<?= $this->endSection() ?>