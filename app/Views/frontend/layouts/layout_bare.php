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

    <main class="flex flex-col gap-12 lg:gap-24 2xl:gap-36">
        <?php $topSection = $this->renderSection('top'); ?>
        <?php if (trim($topSection) !== ''): ?>
            <div class="px-4 xl:container xl:mx-auto" data-region="top">
                <?= $topSection ?>
            </div>
        <?php endif; ?>

        <?= $this->renderSection('main') ?>

        <?php $bottomSection = $this->renderSection('bottom'); ?>
        <?php if (trim($bottomSection) !== ''): ?>
            <div class="px-4 xl:container xl:mx-auto" data-region="bottom">
                <?= $bottomSection ?>
            </div>
        <?php endif; ?>
    </main>

    <?php $footerSection = $this->renderSection('footer'); ?>
    <?php if (trim($footerSection) !== ''): ?>
        <footer class="mt-auto flex flex-col">
            <div data-region="footer">
                <?= $footerSection ?>
            </div>
        </footer>
    <?php endif; ?>

</body>

</html>