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

    <header data-region="header">
        <?= view_cell('FrontendCell::nav') ?>
        <?= $this->renderSection('header') ?>
    </header>

    <main class="flex flex-col gap-12 lg:gap-24 2xl:gap-36 my-12 lg:my-24">


        <?php $heroSection = $this->renderSection('hero'); ?>
        <?php if (trim($heroSection) !== ''): ?>
            <div data-region="hero">
                <?= $heroSection ?>
            </div>
        <?php endif; ?>

        <?php $topSection = $this->renderSection('top'); ?>
        <?php if (trim($topSection) !== ''): ?>
            <div class="px-4 xl:container xl:mx-auto" data-region="top">
                <?= $topSection ?>
            </div>
        <?php endif; ?>

        <div class="px-4 xl:container xl:mx-auto">
            <div class="flex flex-col lg:flex-row gap-8 lg:gap-12">
                <section class="flex-1" aria-label="Main top content">
                    <?= $this->renderSection('main_top') ?>
                </section>

                <aside class="hidden lg:flex flex-col gap-8 lg:gap-12 lg:w-[30%]" aria-label="Sidebar top">
                    <?= $this->renderSection('sidebar_top') ?>
                </aside>
            </div>
        </div>

        <div data-region="middle">
            <?= $this->renderSection('middle') ?>
        </div>

        <div class="px-4 xl:container xl:mx-auto">
            <div class="flex flex-col lg:flex-row gap-8 lg:gap-12">
                <section class="flex-1" aria-label="Main bottom content">
                    <?= $this->renderSection('main_bottom') ?>
                </section>

                <aside class="flex flex-col gap-8 lg:gap-12 lg:w-[30%]" aria-label="Sidebar bottom">
                    <?= $this->renderSection('sidebar_bottom') ?>
                </aside>
            </div>
        </div>


        <?php $bottomSection = $this->renderSection('bottom'); ?>
        <?php if (trim($bottomSection) !== ''): ?>
            <div class="px-4 xl:container xl:mx-auto" data-region="bottom">
                <?= $bottomSection ?>
            </div>
        <?php endif; ?>
    </main>

    <footer class="mt-auto flex flex-col">
        <div data-region="call-to-action">
            <?= $this->renderSection('call_to_action') ?>
        </div>

        <div data-region="footer">
            <?= $this->renderSection('footer') ?>
            <?= view_cell('FrontendCell::footer') ?>
        </div>
    </footer>

</body>

</html>