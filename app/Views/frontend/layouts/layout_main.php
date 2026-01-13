<!DOCTYPE html>
<html lang="<?= setting('site.language') ?>" data-theme="<?= setting('theme.main') ?>" data-default-theme="<?= setting('theme.main') ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="base-url" content="<?= base_url(); ?>">
    <meta name="color-scheme" content="light dark">
    <title><?= (!empty($site_title) ? $site_title . ' | ' . setting('meta.siteName') : setting('meta.siteTitle')) ?></title>
    <meta name="description" content="<?= setting('meta.siteDescription') ?>" />

    <?= $this->include('frontend/layouts/scripts') ?>
    <?= $this->include('frontend/layouts/stylesheets') ?>
    <?= $this->renderSection('head') ?>
</head>

<body class="min-h-screen flex flex-col <?= body_class() ?>">

    <header>
        <?= view_cell('FrontendCell::nav') ?>
        <?= $this->renderSection('header') ?>
    </header>

    <main class="flex-1">
        <?= $this->renderSection('main') ?>
    </main>

    <footer data-theme="<?=setting('theme.darkBlocks')?>">
        <?= view_cell('FrontendCell::footer') ?>
    </footer>

</body>

</html>

