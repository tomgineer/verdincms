<?= $this->extend('layout_app') ?>
<?= $this->section('main') ?>

<div class="container container--post mt-3 mt-sm-2 mb-5">
    <h1 class="topic-title mb-2"><?=esc($site_title)?></h1>
    <?= view('components/post_list', ['posts' => $post_data]) ?>
</div>

<?php if (!empty($post_data['pagination']) && is_array($post_data['pagination'])): ?>
    <?= view('components/pagination', ['pagination' => $post_data['pagination']]) ?>
<?php endif; ?>

<?php if (!empty($trending)):?>
    <div class="container container--xl mb-5">
        <h2 class="h1 plain-list-title">Trending</h2>
        <?= view('components/plain_list', ['posts' => $trending['posts'], 'style' => 'plain-list--columns']) ?>
    </div>
<?php endif;?>

<!--</?php if (!empty($ai)):?>
    </?= $this->include('components/ai_knowledge') ?>
</?php endif;?>-->

<?= $this->endSection() ?>
