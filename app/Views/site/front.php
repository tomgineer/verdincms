<?= $this->extend('layout_app') ?>
<?= $this->section('main') ?>

<div class="container mx-auto px-4">
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
            <a href="https://t.me/tomsnews" target="_blank">
                <img src="<?=path_gfx().'telegram.webp?v=3'?>" alt="Follow Us on Telegram" loading="lazy">
            </a>

            <h2 class="text-3xl text-primary mt-8">Featured</h2>
            <?= view('components/plain_list', ['posts' => $featured['posts']]) ?>

            <a href="https://x.com/tomsnews_blog" target="_blank">
                <img src="<?=path_gfx().'twitter.webp?v=3'?>" alt="Follow Us on Twitter (X)" loading="lazy">
            </a>

            <h2 class="text-3xl text-primary mt-8">Trending</h2>
            <?= view('components/plain_list', ['posts' => $trending['posts']]) ?>

            <h3 class="text-3xl text-primary mt-8">Popular</h3>
            <?= view('components/plain_list', ['posts' => $popular['posts']]) ?>
        </aside>

    </div>
</div>

<?= $this->endSection() ?>
