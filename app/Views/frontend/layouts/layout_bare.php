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
    </header>

    <main class="flex-1 flex flex-col">
        <?= $this->renderSection('main') ?>
    </main>

    <?php $footerSection = $this->renderSection('footer'); ?>
    <?php if (trim($footerSection) !== ''): ?>
        <footer>
            <div data-region="footer">
                <?= $footerSection ?>
            </div>
        </footer>
    <?php endif; ?>

</body>

</html>