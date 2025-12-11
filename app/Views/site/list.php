<?= $this->extend('layout_app') ?>
<?= $this->section('main') ?>


<div class="container mx-auto px-4 mt-8 lg:mt-18 mb-12 lg:mb-24">
    <div class="flex flex-col lg:flex-row gap-8">

        <section class="flex-1">
            <h1 class="text-4xl text-base-content/70 mb-8 text-shadow-lg"><?= esc($site_title) ?></h1>
            <?= view('components/post_list', ['posts' => $post_data['posts']]) ?>
            <?= isset($post_data['pagination']) ? view('components/pagination', ['pagination' => $post_data['pagination']]) : '' ?>
        </section>

        <aside class="w-full lg:w-[30%]">
            <div class="lg:sticky lg:top-8">
                <?php if (!empty($stats)): ?>
                    <div class="stats grid grid-cols-2 grid-flow-row">
                        <?php foreach ($stats as $stat): ?>
                            <div class="stat stat-lg place-items-center">
                                <div class="stat-title"><?= esc($stat['title']) ?></div>
                                <div class="stat-value text-secondary"><?= esc($stat['value']) ?></div>
                                <div class="stat-desc text-secondary"><?= esc($stat['desc']) ?></div>
                            </div>
                        <?php endforeach; ?>
                        <div class="stat stat-lg place-items-center !border-r-0">
                            <div class="stat-title">Public Posts</div>
                            <div class="stat-value"><?= esc($public_posts) ?></div>
                            <div class="stat-desc">Only Public</div>
                        </div>
                        <div class="stat stat-lg place-items-center !border-r-0">
                            <div class="stat-title">Total Posts</div>
                            <div class="stat-value"><?= esc($total_posts) ?></div>
                            <div class="stat-desc">Regardless of status</div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (!empty($trending)): ?>
                    <h2 class="text-3xl text-primary mt-8 mb-2">Trending</h2>
                    <?= view('components/plain_list', ['posts' => $trending['posts']]) ?>
                <?php endif; ?>

                <?php if (!empty($featured)): ?>
                    <h2 class="text-3xl text-primary mt-8 mb-2">Featured</h2>
                    <?= view('components/plain_list', ['posts' => $featured['posts']]) ?>
                <?php endif; ?>
            </div>
        </aside>

    </div>
</div>

<?= $this->endSection() ?>