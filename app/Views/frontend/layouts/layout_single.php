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
            <section aria-label="Main content">
                <?= $this->renderSection('main') ?>
            </section>
        </div>

        <?php $followUpSection = $this->renderSection('follow_up'); ?>
        <?php if (trim($followUpSection) !== ''): ?>
            <div class="px-4 xl:container xl:mx-auto" data-region="follow-up">
                <?= $followUpSection ?>
            </div>
        <?php endif; ?>

        <?php $asideTopSection = $this->renderSection('aside_top'); ?>
        <?php if (trim($asideTopSection) !== ''): ?>
            <aside class="px-4 xl:container xl:mx-auto" aria-label="Aside Top">
                <?= $asideTopSection ?>
            </aside>
        <?php endif; ?>

        <?php $middleSection = $this->renderSection('middle'); ?>
        <?php if (trim($middleSection) !== ''): ?>
            <div data-region="middle">
                <?= $middleSection ?>
            </div>
        <?php endif; ?>

        <?php $asideBottomSection = $this->renderSection('aside_bottom'); ?>
        <?php if (trim($asideBottomSection) !== ''): ?>
            <aside class="px-4 xl:container xl:mx-auto" aria-label="Aside Bottom">
                <?= $asideBottomSection ?>
            </aside>
        <?php endif; ?>

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