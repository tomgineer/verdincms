<!DOCTYPE html>
<html lang="<?=setting('site_language')?>">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="base-url" content="<?=base_url();?>">
        <meta name="color-scheme" content="light dark">

        <?php if (!empty($post)): ?>
            <title><?= htmlspecialchars($post['title']) ?> | <?= setting('site_name') ?></title>
            <meta name="description" content="<?= htmlspecialchars($post['subtitle']) ?>"/>
            <?= $this->include('components/meta_post') ?>

        <?php elseif (!empty($page)): ?>
            <title><?= htmlspecialchars($page['title']) ?> | <?= setting('site_name') ?></title>
            <meta name="description" content="<?= htmlspecialchars($page['subtitle']) ?>"/>
            <?= $this->include('components/meta_page') ?>

        <?php else: ?>
            <title><?= (!empty($site_title) ? $site_title . ' | ' . setting('site_name') : setting('site_title')) ?></title>
            <meta name="description" content="<?= setting('site_description') ?>"/>
        <?php endif; ?>

        <link rel="stylesheet" href="<?=path_assets()?>fonts/fonts.css?v=<?=setting('version')?>">
        <link rel="stylesheet" href="<?=path_css()?>vernito.css?v=<?=setting('version')?>">
        <link rel="stylesheet" href="<?=path_css()?>app.css?v=<?=setting('version')?>">

        <?php if ( !empty($highlight) ): ?>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/highlightjs/cdn-release@11.11.1/build/styles/github-dark.min.css">
            <script src="https://cdn.jsdelivr.net/gh/highlightjs/cdn-release@11.11.1/build/highlight.min.js"></script>
        <?php endif;?>

        <script src="<?=path_js()?>app-dist.js?v=<?=setting('version')?>" defer></script>
        <?= $this->include('components/favicon') ?>
        <?= $this->renderSection('head') ?>

    </head>

    <body class="<?=body_class()?>" id="<?=body_class()?>">

        <header>
            <?= $this->include('nav/nav') ?>
            <?= $this->renderSection('header') ?>
        </header>

        <main>
            <?= $this->renderSection('main') ?>
        </main>

        <footer class="mt-auto">
            <?= $this->include('site/footer') ?>
        </footer>

    </body>
</html>