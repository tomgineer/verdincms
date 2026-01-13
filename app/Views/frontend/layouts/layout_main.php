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
    <?= $this->include('frontend/layouts/styles') ?>
    <?= $this->renderSection('head') ?>
</head>

<body class="min-h-screen flex flex-col <?= body_class() ?>">

    <header class="border-2 border-blue-800" data-region="header">
        <?= view_cell('FrontendCell::nav') ?>
        <?= $this->renderSection('header') ?>
    </header>

    <main class="flex flex-col gap-8 lg:gap-12 2xl:gap-16">
        <div class="border-2 border-blue-800" data-region="hero">
            <?= $this->renderSection('hero') ?>
        </div>

        <div class="px-4 xl:container xl:mx-auto border-2 border-blue-800" data-region="top">
            <?= $this->renderSection('top') ?>
        </div>

        <div class="px-2 lg:px-4 xl:container xl:mx-auto border-2 border-blue-800">
            <div class="flex flex-col lg:flex-row gap-8 lg:gap-12 border-2 border-blue-800">
                <section class="flex-1 border-2 border-blue-800" aria-label="Main top content">
                    <?= $this->renderSection('main_top') ?>
                </section>

                <aside class="w-full lg:w-[30%] hidden lg:block border-2 border-blue-800" aria-label="Sidebar top">
                    <?= $this->renderSection('sidebar_top') ?>
                </aside>
            </div>
        </div>

        <div class="border-2 border-blue-800" data-region="middle">
            <?= $this->renderSection('middle') ?>
        </div>

        <div class="px-2 lg:px-4 xl:container xl:mx-auto border-2 border-blue-800">
            <div class="flex flex-col lg:flex-row gap-8 lg:gap-12 border-2 border-blue-800">
                <section class="flex-1 border-2 border-blue-800" aria-label="Main bottom content">
                    <?= $this->renderSection('main_bottom') ?>
                </section>

                <aside class="w-full lg:w-[30%] border-2 border-blue-800" aria-label="Sidebar bottom">
                    <?= $this->renderSection('sidebar_bottom') ?>
                </aside>
            </div>
        </div>

        <div class="px-4 xl:container xl:mx-auto border-2 border-blue-800" data-region="bottom">
            <?= $this->renderSection('bottom') ?>
        </div>
    </main>

    <footer class="mt-auto flex flex-col border-2 border-blue-800">
        <div class="border-2 border-blue-800" data-region="call-to-action">
            <?= $this->renderSection('call_to_action') ?>
        </div>

        <div class="border-2 border-blue-800" data-region="footer">
            <?= $this->renderSection('footer') ?>
        </div>
    </footer>

</body>

</html>

