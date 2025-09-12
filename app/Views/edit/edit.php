<?= $this->extend('layout_admin2') ?>
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

<div class="toast toast-top toast-start mt-16 hidden" data-toast-save>
    <div class="alert alert-success font-semibold">
        <span>Post Saved!</span>
    </div>
</div>

<?= $this->endSection() ?>