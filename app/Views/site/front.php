<?= $this->extend('layout_app') ?>
<?= $this->section('main') ?>

<div class="container mx-auto px-4 mt-18">
    <div class="flex flex-col lg:flex-row gap-8">

        <section class="flex-1">
            <?= view('components/post_list', ['posts' => $latest_updates]) ?>
            <!-- TODO: Add Pagination -->
        </section>

        <aside class="w-full lg:w-[30%]">
            <div class="sticky top-8">
                <h2 class="text-3xl text-primary mt-8 mb-2">Featured</h2>
                <?= view('components/plain_list', ['posts' => $featured['posts']]) ?>

                <h2 class="text-3xl text-primary mt-8 mb-2">Trending</h2>
                <?= view('components/plain_list', ['posts' => $trending['posts']]) ?>

                <h2 class="text-3xl text-primary mt-8 mb-2">Popular</h2>
                <?= view('components/plain_list', ['posts' => $popular['posts']]) ?>
            </div>
        </aside>

    </div>
</div>

<?= $this->endSection() ?>
