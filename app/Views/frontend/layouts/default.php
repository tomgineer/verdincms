<!DOCTYPE html>
<html lang="<?= setting('site.language') ?>" data-theme="<?= setting('theme.main') ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= body_class() === 'site-index' ? csrf_meta() : '' ?>
    <meta name="base-url" content="<?= base_url(); ?>">
    <meta name="color-scheme" content="light dark">

    <?php if (!empty($post)): ?>
        <title><?= htmlspecialchars($post['title']) ?> | <?= setting('meta.siteName') ?></title>
        <meta name="description" content="<?= htmlspecialchars($post['subtitle']) ?>" />
        <?= $this->include('frontend/partials/meta_post') ?>

    <?php elseif (!empty($page)): ?>
        <title><?= htmlspecialchars($page['title']) ?> | <?= setting('meta.siteName') ?></title>
        <meta name="description" content="<?= htmlspecialchars($page['subtitle']) ?>" />
        <?= $this->include('frontend/partials/meta_page') ?>

    <?php else: ?>
        <title><?= (!empty($site_title) ? $site_title . ' | ' . setting('meta.siteName') : setting('meta.siteTitle')) ?></title>
        <meta name="description" content="<?= setting('meta.siteDescription') ?>" />
    <?php endif; ?>

    <link rel="stylesheet" href="<?= path_css() ?>tailwind.css?v=<?= setting('system.version') ?>">

    <?php foreach (setting('theme.extraFonts') ?: ['default'] as $font): ?>
        <link rel="stylesheet" href="<?= path_assets() ?>fonts/<?= esc($font) ?>/fonts.css">
    <?php endforeach; ?>

    <?php if (!empty($highlight)): ?>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/highlightjs/cdn-release@11.11.1/build/styles/github-dark.min.css">
        <script src="https://cdn.jsdelivr.net/gh/highlightjs/cdn-release@11.11.1/build/highlight.min.js"></script>
    <?php endif; ?>

    <script src="<?= path_js() ?>app-dist.js?v=<?= setting('system.version') ?>" defer></script>
    <?= $this->include('frontend/partials/favicon') ?>
    <?= $this->renderSection('head') ?>

</head>

<body class="min-h-screen flex flex-col <?= body_class() ?>" id="<?= body_class() ?>">

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
