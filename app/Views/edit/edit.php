<?= $this->extend('layout_admin') ?>
<?= $this->section('head') ?>

    <script src="<?=path_assets()?>ckeditor/ckeditor.js?v=<?=setting('system.version')?>"></script>
    <link rel="stylesheet" href="<?=path_assets()?>ckeditor/ckeditor.css?v=<?=setting('system.version')?>">

<?= $this->endSection() ?>

<?= $this->section('main') ?>

<main class="edit-main mb-32">
    <?= $this->include('edit/main') ?>
</main>

<aside>
    <?= $this->include('edit/sidebar') ?>
</aside>

<?= $this->include('edit/components/toasts') ?>

<?= $this->endSection() ?>