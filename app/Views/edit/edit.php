<?= $this->extend('layout_admin') ?>
<?= $this->section('head') ?>

    <script src="<?=path_assets()?>ckeditor/ckeditor.js?v=<?=setting('version')?>"></script>
    <link rel="stylesheet" href="<?=path_assets()?>ckeditor/ckeditor.css?v=<?=setting('version')?>">

<?= $this->endSection() ?>

<?= $this->section('main') ?>

<aside class="edit-aside-left">
    <?= $this->include('edit/components/sidebar_left') ?>
</aside>

<aside class="edit-aside-right">
    <?= $this->include('edit/components/sidebar_right') ?>
</aside>

<main class="edit-main">
    <?= $this->include('edit/main') ?>
</main>

<?= $this->endSection() ?>