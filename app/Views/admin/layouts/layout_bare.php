<!DOCTYPE html>
<html lang="<?=setting('site.language')?>" data-theme="dark">
    <head>
        <?= $this->include('admin/layouts/meta') ?>
        <?= $this->include('admin/layouts/scripts') ?>
        <?= $this->include('admin/layouts/styles') ?>
        <?= $this->renderSection('head') ?>
    </head>

    <body class="min-h-screen flex flex-col <?=body_class()?>" data-theme="dark" id="<?=body_class()?>" data-admin="true">
        <header>
            <?=view_cell('FrontendCell::nav')?>
            <?= $this->renderSection('header') ?>
        </header>

        <main>
            <?= $this->renderSection('main') ?>
        </main>
    </body>

</html>

