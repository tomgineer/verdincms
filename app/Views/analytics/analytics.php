<?= $this->extend('layout_admin') ?>
<?= $this->section('head') ?>
    <?php if ( !empty($useChartJS) ):?>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <?php endif;?>
<?= $this->endSection() ?>

<?= $this->section('main') ?>

<header class="dash-header">
    <?= $this->include('analytics/components/header') ?>
</header>

<aside class="dash-aside">
    <?= $this->include('analytics/components/sidenav') ?>
</aside>

<main class="dash-main">
    <div class="container container--3xl">
        <?php if ( !empty($path) ):?>
            <?= $this->include('analytics/pages/' . $path) ?>
        <?php endif;?>
    </div>
</main>

<?= $this->endSection() ?>