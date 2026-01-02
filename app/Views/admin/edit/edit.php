<?= $this->extend('admin/layouts/default') ?>
<?= $this->section('head') ?>

    <script src="<?=path_assets()?>ckeditor/ckeditor.js?v=<?=ver()?>"></script>
    <link rel="stylesheet" href="<?=path_assets()?>ckeditor/ckeditor.css?v=<?=ver()?>">

<?= $this->endSection() ?>

<?= $this->section('main') ?>

<main class="edit-main mb-32 px-4">
    <?= $this->include('admin/edit/main') ?>
</main>

<aside>
    <?= $this->include('admin/edit/sidebar') ?>
</aside>

<?= $this->include('admin/edit/partials/toasts') ?>

<?= $this->endSection() ?>

