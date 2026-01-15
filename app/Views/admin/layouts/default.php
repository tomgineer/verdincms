<!DOCTYPE html>
<html lang="<?=setting('site.language')?>" data-theme="dark">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="base-url" content="<?=base_url();?>">
        <title><?=$title?></title>
        <meta name="description" content="<?=setting('meta.siteDescription')?>"/>
        <link rel="stylesheet" href="<?=path_assets()?>fonts/default/fonts.css">

        <?= $this->renderSection('head') ?>

        <link rel="stylesheet" href="<?=path_css()?>tailwind.css?v=<?=ver()?>">

        <script src="<?=path_js()?>app-dist.js?v=<?=ver()?>" defer></script>
        <script src="<?=path_js()?>admin-dist.js?v=<?=ver()?>" defer></script>

    </head>

    <body class="min-h-dvh flex flex-col <?=body_class()?>" data-theme="dark" id="<?=body_class()?>" data-admin="true">

        <header>
            <?=view_cell('FrontendCell::nav')?>
            <?= $this->renderSection('header') ?>
        </header>

        <main>
            <?= $this->renderSection('main') ?>
        </main>

    </body>

</html>

