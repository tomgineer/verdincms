<?= $this->extend('frontend/layouts/layout_single') ?>

<?= $this->section('main') ?>
    <article>
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
            <?= $post['body'] ?>
        </div>
    </article>
<?= $this->endSection() ?>

<?= $this->section('follow_up') ?>
    <?php if (setting('cells.share')): ?>
        <?= $this->include('frontend/cells/share') ?>
    <?php endif; ?>
<?= $this->endSection() ?>

<?= $this->section('aside_top') ?>
    <?php if (setting('theme.postExtras')): ?>
        <section>
            <h2 class="text-3xl lg:text-4xl mb-4 text-primary"><?=lang('App.related')?></h2>
            <?= view_cell('FrontendCell::related', ['post_id' => (int)$post['id'], 'topic_id' => (int)$post['topic_id'], 'gridStyle' => 'columns']) ?>
        </section>
    <?php endif; ?>
<?= $this->endSection() ?>

<?= $this->section('middle') ?>
    <?php if (setting('cells.newsletter')): ?>
        <?=view_cell('FrontendCell::newsletter')?>
    <?php endif; ?>
<?= $this->endSection() ?>

<?= $this->section('aside_bottom') ?>
    <?php if (setting('theme.postExtras')): ?>
        <section class="mb-12 lg:mb-24">
            <h2 class="text-3xl lg:text-4xl mb-4 text-primary"><?=lang('App.trending')?></h2>
            <?= view_cell('FrontendCell::trending', ['gridStyle' => 'columns']) ?>
        </section>
    <?php endif; ?>
<?= $this->endSection() ?>

<?= $this->section('footer') ?>
    <?= view_cell('FrontendCell::footer') ?>
<?= $this->endSection() ?>