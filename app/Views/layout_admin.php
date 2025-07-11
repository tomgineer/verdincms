<!DOCTYPE html>
<html lang="<?=setting('site.language')?>">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="base-url" content="<?=base_url();?>">
        <title><?=$title?></title>
        <meta name="description" content="<?=setting('meta.site_description')?>"/>
        <?= $this->include('components/favicon') ?>
        <link rel="stylesheet" href="<?=path_assets()?>fonts/fonts-admin.css">

        <?= $this->renderSection('head') ?>

        <link rel="stylesheet" href="<?=path_css()?>vernito.css?v=<?=setting('system.version')?>">
        <link rel="stylesheet" href="<?=path_css()?>admin.css?v=<?=setting('system.version')?>">
        <script src="<?=path_js()?>admin-dist.js?v=<?=setting('system.version')?>" defer></script>

    </head>

    <body class="<?=body_class()?>" data-theme="dark" id="<?=body_class()?>">
        <?= $this->renderSection('main') ?>
    </body>

</html>