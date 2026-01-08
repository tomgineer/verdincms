<?= $this->extend('frontend/layouts/default') ?>
<?= $this->section('main') ?>

<article class="container mx-auto px-4 mt-8 lg:mt-16 mb-16 lg:mb-24">

    <div class="card lg:card-side rounded-none">
        <figure class="w-full lg:w-3/10">
            <img class="rounded-[25%_0_25%_0] shadow-sm aspect-square" src="<?= path_img() . esc($post['photo']) . '.webp' ?>" alt="<?= esc($post['title']) ?>">
        </figure>

        <div class="card-body w-full lg:w-2/3 px-2 lg:px-8">

            <h1 class="card-title text-3xl xl:text-5xl font-medium leading-tight mb-4"><?= esc($post['title']) ?></h1>

            <p class="text-2xl prose"><?= esc($post['subtitle']) ?></p>

            <div class="card-actions justify-end">
                <a class="text-secondary hover:underline" href="<?= site_url('author/' . esc($post['author_handle'])) ?>"><?= esc($post['author']) ?></a>
                <span class="text-base-content/50">/ <?= esc($post['ago']) ?> <?= lang('App.in') ?></span>
                <a class="text-secondary hover:underline" href="<?= site_url('topic/' . esc($post['topic_slug'])) ?>"><?= esc($post['topic']) ?></a>
            </div>

            <?php if (tier() != 0): ?>
                <div class="self-end">
                    <div class="badge badge-sm badge-dash badge-info"><?= esc($post['hits']) ?> Hits</div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="w-full lg:max-w-[80ch] mx-auto mt-12 lg:mt-24 leading-relaxed text-xl prose prose-neutral">
        <?= esc($post['body'], 'raw') ?>
    </div>

</article>

<?php if (setting('theme.postShare')): ?>
    <?= $this->include('frontend/partials/share') ?>
<?php endif; ?>

<?php if (setting('theme.postExtras')): ?>
    <section class="container mx-auto px-4 mb-8">
        <h2 class="text-3xl mb-4 text-primary">Related</h2>
        <?= view_cell('FrontendCell::related', ['post_id' => (int)$post['id'], 'topic_id' => (int)$post['topic_id'], 'gridStyle' => 'columns']) ?>
    </section>

    <section class="container mx-auto px-4 mb-24 lg:mb-36">
        <h2 class="text-3xl mb-4 text-primary">Trending</h2>
        <?= view_cell('FrontendCell::trending', ['gridStyle' => 'columns']) ?>
    </section>
<?php endif; ?>

<?= $this->endSection() ?>