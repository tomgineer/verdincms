<?= $this->extend('layout_app') ?>
<?= $this->section('main') ?>

<div class="container mx-auto px-4 mt-8 lg:mt-18 mb-12 lg:mb-24">
    <div class="flex flex-col lg:flex-row gap-8">

        <section class="flex-1">
            <?= view('components/post_list', ['posts' => $latest_updates['posts']]) ?>
            <?= view('components/pagination', ['pagination' => $latest_updates['pagination']]) ?>
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

    <div class="max-w-5xl mx-auto mt-20 flex justify-center">
        <div class="font-heading text-sm tracking-wide flex gap-1 items-center py-1 px-3 rounded border border-dashed border-primary text-primary font-semibold">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
            </svg>

            <span class="font-bold text-base-content/90">100%</span> Human Created Texts
        </div>
    </div>

</div>

<?= $this->include('components/newsletter') ?>

<?= $this->endSection() ?>