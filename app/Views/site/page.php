<?= $this->extend('layout_app') ?>
<?= $this->section('main') ?>

<article>

    <?php if ( $page['disable_hero']==0 ):?>
        <div class="relative w-full h-[40vh] flex items-center justify-center overflow-hidden">
            <h1 class="absolute z-10 text-5xl font-bold text-white text-center text-shadow-lg">
                <?= esc($page['title']) ?>
            </h1>
            <picture class="absolute inset-0 z-0">
                <source srcset="<?= path_img() . esc($page['photo']) ?>.webp" media="(min-width: 1921px)">
                <img class="w-full h-full object-cover brightness-50" src="<?= path_img_tn() . esc($page['photo']) ?>.webp" alt="Post Photo">
            </picture>
        </div>

    <?php else:?>
        <h1 class="w-full lg:max-w-[50ch] mx-auto text-5xl leading-tight mt-8"><?=esc($page['title'])?></h1>
    <?php endif;?>

    <section class="container mx-auto px-4 mt-4 lg:mt-12">
        <h2 class="w-full lg:max-w-[65ch] mx-auto text-content text-3xl mt-8 leading-tight"><?= esc($page['subtitle']) ?></h2>

        <div class="w-full lg:max-w-[80ch] mx-auto mt-4 lg:mt-8 leading-relaxed text-xl prose prose-neutral">
            <?= esc($page['body'], 'raw') ?>
        </div>
    </section>

</article>

<section class="container mx-auto px-4 py-12 mt-8 lg:py-24 lg:mt-16">
    <h2 class="text-3xl mb-4 text-primary">Featured</h2>
    <?= view('components/plain_list', ['posts' => $featured['posts'], 'style' => 'plain-list--columns']) ?>
</section>

<?= $this->endSection() ?>
