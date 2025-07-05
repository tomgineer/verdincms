<?= $this->extend('layout_app') ?>
<?= $this->section('main') ?>

<article class="page">

    <?php if ( $page['disable_hero']==0 ):?>
        <section class="page__hero">
            <picture>
                <source srcset="<?= path_img() . esc($page['photo']) . '.webp' ?>" media="(min-width: 1921px)">
                <img class="page__image" src="<?= path_img_tn() . esc($page['photo']) . '.webp' ?>" alt="Post Photo" loading="lazy">
            </picture>

            <h1 class="page__title"><?=esc($page['title'])?></h1>
        </section>

    <?php else:?>
        <h1 class="page__title"><?=esc($page['title'])?></h1>
    <?php endif;?>

    <div class="container container--xl">
        <section class="post__body mt-2 mt-sm-1 mb-7">
            <?php if (!empty($page['subtitle'])):?>
                <p><?= esc($page['subtitle']) ?></p>
            <?php endif;?>

            <?= esc($page['body'], 'raw') ?>
        </section>
    </div>

    <?php if( tier() >= 10 ):?>
        <?= $this->include('components/page_info') ?>
    <?php endif;?>

</article>

<div class="container container--xl mb-5">
    <h2 class="h1 plain-list-title">Featured</h2>
    <?= view('components/plain_list', ['posts' => $featured['posts'], 'style' => 'plain-list--columns']) ?>
</div>

<?= $this->endSection() ?>
