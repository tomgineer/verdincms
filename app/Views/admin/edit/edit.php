<?= $this->extend('admin/layouts/default') ?>
<?= $this->section('head') ?>

    <script src="<?=path_assets()?>ckeditor/ckeditor.js?v=<?=setting('system.version')?>"></script>
    <link rel="stylesheet" href="<?=path_assets()?>ckeditor/ckeditor.css?v=<?=setting('system.version')?>">

<?= $this->endSection() ?>

<?= $this->section('main') ?>

<main class="edit-main mb-32">
    <?= $this->include('admin/edit/main') ?>
</main>

<aside>
    <?= $this->include('admin/edit/sidebar') ?>
</aside>

<?= $this->include('admin/edit/components/toasts') ?>

<?= $this->endSection() ?>
