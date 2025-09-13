<!DOCTYPE html>
<html lang="<?=setting('site.language')?>">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="base-url" content="<?=base_url();?>">
        <title><?=$title?></title>
        <meta name="description" content="<?=setting('meta.site_description')?>"/>
        <?= $this->include('components/favicon') ?>
        <link rel="stylesheet" href="<?=path_assets()?>fonts/fonts.css">
        <link rel="stylesheet" href="<?=path_assets()?>fonts/bebas.css">

        <?= $this->renderSection('head') ?>

        <link rel="stylesheet" href="<?=path_css()?>tailwind.css?v=<?=setting('system.version')?>">

        <script src="<?=path_js()?>app-dist.js?v=<?=setting('system.version')?>" defer></script>
        <script src="<?=path_js()?>admin-dist.js?v=<?=setting('system.version')?>" defer></script>

    </head>

    <body class="<?=body_class()?>" data-theme="dark" id="<?=body_class()?>">

        <header>
            <?= $this->include('navbar/navbar') ?>
            <?= $this->renderSection('header') ?>
        </header>

        <main>
            <?= $this->renderSection('main') ?>
        </main>

    </body>

</html>