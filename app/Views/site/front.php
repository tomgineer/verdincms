<?= $this->extend('layout_app') ?>
<?= $this->section('main') ?>

<div class="container mx-auto px-4 mt-8 lg:mt-18 mb-12 lg:mb-24">
    <div class="flex flex-col lg:flex-row gap-8">

        <section class="flex-1">
            <?= view('components/post_list', ['posts' => $latest_updates['posts']]) ?>
            <?= view('components/pagination', ['pagination' => $latest_updates['pagination']]) ?>
        </section>

        <aside class="w-full lg:w-[30%]">
            <div class="xl:sticky xl:top-8">
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
        <div class="animated-border bg-base-100 font-heading text-sm tracking-wide">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                class="size-5 text-white/70">
                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
            </svg>

            <span class="ml-1 font-bold text-white">100%</span>
            <span class="ml-1 text-white/80">Human Generated Content</span>
        </div>
    </div>

</div>

<?= $this->include('components/newsletter') ?>

<?= $this->endSection() ?>