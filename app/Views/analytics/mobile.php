<?= $this->extend('layout_admin') ?>
<?= $this->section('main') ?>

<header>
    <div class="container">
        <a href="<?=base_url()?>"><img class="dash-header-inline__logo" src="<?=path_gfx().'verdincms.svg'?>" alt="VerdinCMS Logo"></a>
        <h1 class="mobile-analytics__main-title">Mobile Analytics</h1>
        <p>Made with endless love for Vicky 💖</p>
    </div>
</header>

<main class="container mb-7">

    <section class="mobile-analytics">
        <h3 class="mobile-analytics__title">Live Data</h3>

        <ul class="mobile-analytics-blocks mobile-analytics-blocks--colored">
            <?php foreach ($live as $key => $value): ?>
                <li class="mobile-analytics-blocks__item">
                    <span class="mobile-analytics-blocks__value" data-dash-count-up="<?=esc($value)?>">0</span>
                    <span class="mobile-analytics-blocks__label"><?= esc(camelToWords($key)) ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>

    <section class="mobile-analytics">
        <h3 class="mobile-analytics__title">Visitors</h3>

        <ul class="mobile-analytics-lists">
            <?php foreach ($visitorsAndHits['visitors'] as $item):?>
                <li class="mobile-analytics-lists__item">
                    <span class="mobile-analytics-lists__label"><?=esc($item['f_created'])?></span>
                    <span class="mobile-analytics-lists__value"><?=esc($item['cnt'])?></span>
                </li>
            <?php endforeach;?>
        </ul>
    </section>

    <section class="mobile-analytics">
        <h3 class="mobile-analytics__title">Hits</h3>

        <ul class="mobile-analytics-lists">
            <?php foreach ($visitorsAndHits['hits'] as $item):?>
                <li class="mobile-analytics-lists__item">
                    <span class="mobile-analytics-lists__label"><?=esc($item['f_created'])?></span>
                    <span class="mobile-analytics-lists__value"><?=esc($item['cnt'])?></span>
                </li>
            <?php endforeach;?>
        </ul>
    </section>

    <?php foreach ($overview as $category => $items): ?>
        <section class="mobile-analytics">
            <h3 class="mobile-analytics__title"><?=esc(ucwords(str_replace('_', ' ', $category)))?></h3>

            <ul class="mobile-analytics-lists">
                <?php foreach ($items as $label => $value): ?>
                    <li class="mobile-analytics-lists__item">
                        <span class="mobile-analytics-lists__label"><?=esc($label)?></span>
                        <span class="mobile-analytics-lists__value"><?=esc($value)?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>
    <?php endforeach; ?>

    <section class="mobile-analytics">
        <h3 class="mobile-analytics__title">Countries</h3>

        <ul class="mobile-analytics-lists">
            <?php foreach ($countries as $item):?>
                <li class="mobile-analytics-lists__item">
                    <span class="mobile-analytics-lists__label"><?=esc($item['country'])?></span>
                    <span class="mobile-analytics-lists__value"><?=esc($item['perc'])?> (<?=esc($item['visits'])?>)</span>
                </li>
            <?php endforeach;?>
        </ul>
    </section>

</main>

<?= $this->endSection() ?>