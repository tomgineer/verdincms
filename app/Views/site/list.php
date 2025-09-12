<?= $this->extend('layout_app') ?>
<?= $this->section('main') ?>


<div class="container mx-auto px-4 mt-16">
    <div class="flex flex-col lg:flex-row gap-8">

        <section class="flex-1">
            <h1 class="text-4xl text-base-content/70 mb-8 text-shadow-lg"><?=esc($site_title)?></h1>
            <?= view('components/post_list', ['posts' => $post_data]) ?>
        </section>

        <aside class="w-full lg:w-[30%]">

            <?php if (!empty($stats)):?>
                <div class="stats grid grid-cols-2 grid-flow-row">
                    <?php foreach ($stats as $stat):?>
                        <div class="stat place-items-center">
                            <div class="stat-title"><?=esc($stat['title'])?></div>
                            <div class="stat-value text-secondary"><?=esc($stat['value'])?></div>
                            <div class="stat-desc text-secondary"><?=esc($stat['desc'])?></div>
                        </div>
                    <?php endforeach;?>
                    <div class="stat place-items-center !border-r-0">
                        <div class="stat-title">Public Posts</div>
                        <div class="stat-value"><?=esc($public_posts)?></div>
                        <div class="stat-desc">Only Public</div>
                    </div>
                    <div class="stat place-items-center !border-r-0">
                        <div class="stat-title">Total Posts</div>
                        <div class="stat-value"><?=esc($total_posts)?></div>
                        <div class="stat-desc">Regardless of status</div>
                    </div>
                </div>
            <?php endif;?>

            <?php if (empty($stats)):?>
                <a href="https://www.youtube.com/@TomgineerChannel target="_blank">
                    <img src="<?=path_gfx().'youtube.webp?v=3'?>" alt="Join Me on YouTube" loading="lazy">
                </a>
            <?php endif;?>

            <?php if (!empty($trending)):?>
                <h2 class="text-3xl text-primary mt-8 mb-2">Trending</h2>
                <?= view('components/plain_list', ['posts' => $trending['posts']]) ?>
            <?php endif;?>

            <?php if (!empty($featured)):?>
                <h2 class="text-3xl text-primary mt-8 mb-2">Featured</h2>
                <?= view('components/plain_list', ['posts' => $featured['posts']]) ?>
            <?php endif;?>

            <?php if (empty($stats)):?>
                <a href="https://rumble.com/c/c-7774896" target="_blank">
                    <img src="<?=path_gfx().'rumble.webp?v=3'?>" alt="Join Me on Rumble" loading="lazy">
                </a>
            <?php endif;?>
        </aside>

    </div>
</div>

<?= $this->endSection() ?>
