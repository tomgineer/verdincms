<!DOCTYPE html>
<html lang="<?= setting('site.language') ?>" data-theme="<?= setting('theme.main') ?>" data-default-theme="<?= setting('theme.main') ?>">

<head>
    <?= $this->include('frontend/layouts/meta') ?>
    <?= $this->include('frontend/layouts/scripts') ?>
    <?= $this->include('frontend/layouts/styles') ?>
    <?= $this->renderSection('head') ?>
</head>

<body class="min-h-screen flex flex-col <?= body_class() ?>">
    <header data-region="header">
        <?= view_cell('FrontendCell::nav') ?>
        <?= $this->renderSection('hero') ?>
    </header>

    <main class="flex flex-col gap-12 lg:gap-24 2xl:gap-36 my-12 lg:my-24">
        <?php $topSection = $this->renderSection('top'); ?>
        <?php if (trim($topSection) !== ''): ?>
            <div class="px-4 xl:container xl:mx-auto" data-region="top">
                <?= $topSection ?>
            </div>
        <?php endif; ?>

        <div class="px-4 xl:container xl:mx-auto">
            <div class="flex flex-col lg:flex-row gap-8 lg:gap-12">
                <section class="flex-1" aria-label="Main top content">
                    <?= $this->renderSection('main') ?>
                </section>

                <aside class="hidden lg:flex flex-col gap-8 lg:gap-12 lg:w-[30%]" aria-label="Sidebar top">
                    <?= $this->renderSection('sidebar') ?>
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
        <?php $callToActionSection = $this->renderSection('call_to_action'); ?>
        <?php if (trim($callToActionSection) !== ''): ?>
            <div data-region="call-to-action">
                <?= $callToActionSection ?>
            </div>
        <?php endif; ?>

        <?php $footerSection = $this->renderSection('footer'); ?>
        <?php if (trim($footerSection) !== ''): ?>
            <div data-region="footer">
                <?= $footerSection ?>
            </div>
        <?php endif; ?>
    </footer>
</body>

</html>