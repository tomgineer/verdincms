<?= $this->extend('layout_app') ?>
<?= $this->section('main') ?>

<div class="container mx-auto px-4 mt-16">
    <div class="flex flex-col lg:flex-row gap-8">

        <section class="flex-1">
            <?= view('components/post_list', ['posts' => $latest_updates]) ?>

<!--            </?php if (!empty($latest_updates['pagination']) && is_array($latest_updates['pagination'])): ?>
                <div class="mt-3">
                    </?= view('components/pagination', ['pagination' => $latest_updates['pagination']]) ?>
                </div>
            </?php endif; ?>-->
        </section>

        <aside class="w-full lg:w-[30%]">
            <a href="https://www.youtube.com/@TomgineerChannel target="_blank">
                <img src="<?=path_gfx().'youtube.webp?v=3'?>" alt="Join Me on YouTube" loading="lazy">
            </a>

            <h2 class="text-3xl text-primary mt-8 mb-2">Featured</h2>
            <?= view('components/plain_list', ['posts' => $featured['posts']]) ?>

            <a href="https://rumble.com/c/c-7774896" target="_blank">
                <img src="<?=path_gfx().'rumble.webp?v=3'?>" alt="Join Me on Rumble" loading="lazy">
            </a>

            <h2 class="text-3xl text-primary mt-8 mb-2">Trending</h2>
            <?= view('components/plain_list', ['posts' => $trending['posts']]) ?>

            <h2 class="text-3xl text-primary mt-8 mb-2">Popular</h2>
            <?= view('components/plain_list', ['posts' => $popular['posts']]) ?>
        </aside>

    </div>
</div>

<?= $this->endSection() ?>
