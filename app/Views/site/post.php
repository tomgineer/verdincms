<?= $this->extend('layout_app') ?>
<?= $this->section('main') ?>

<article class="container mx-auto px-4">

    <div class="card lg:card-side bg-base-100">
        <figure class="w-full lg:w-1/3">
            <img class="rounded-[25%_0_25%_0] shadow-sm" src="<?= path_img() . esc($post['photo']) . '.webp' ?>" alt="<?=esc($post['title'])?>">
        </figure>

        <div class="card-body w-full lg:w-2/3">

            <h1 class="card-title text-4xl font-medium leading-tight"><?=esc($post['title'])?></h1>

            <p class="text-lg"><?=esc($post['subtitle'])?></p>

            <div class="card-actions justify-end">
                <a class="text-secondary hover:underline" href="<?=site_url('author/'. esc($post['author_handle']))?>"><?=esc($post['author'])?></a>
                <span class="text-base-content/50">/ <?=esc($post['ago'])?> <?=lang('misc.in')?></span>
                <a class="text-secondary hover:underline" href="<?=site_url('topic/'. esc($post['topic_slug']))?>"><?=esc($post['topic'])?></a>
            </div>
        </div>
    </div>

    <div class="w-full lg:max-w-[80ch] mx-auto mt-16 leading-relaxed text-xl prose prose-neutral">
        <?= esc($post['body'], 'raw') ?>
    </div>


</article>

<section class="container mx-auto px-4 mt-16">
    <h2 class="text-3xl mb-4 text-primary">Related</h2>
    <?= view('components/plain_list', ['posts' => $related, 'style' => 'plain-list--columns']) ?>
</section>

<?= $this->endSection() ?>
