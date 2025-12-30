<?= $this->extend('admin/layouts/default') ?>
<?= $this->section('main') ?>

<div class="container mx-auto px-4 mt-8 lg:mt-18 mb-12 lg:mb-24">
    <div class="flex flex-col lg:flex-row gap-8">

        <section class="flex-1">
            <h1 class="text-4xl text-base-content/70 mb-8 text-shadow-lg"><?= esc($site_title) ?></h1>
            <?= view('frontend/partials/post_list', ['posts' => $post_data['posts']]) ?>
            <?= isset($post_data['pagination']) ? view('frontend/partials/pagination', ['pagination' => $post_data['pagination']]) : '' ?>
        </section>

        <aside class="w-full lg:w-[30%]">
            <?=view_cell('AdminCell::stats', ['statsType' => $type])?>
        </aside>

    </div>
</div>

<?= $this->endSection() ?>