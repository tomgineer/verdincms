<?= $this->extend('layout_app') ?>
<?= $this->section('main') ?>

<article class="post mt-2 mt-sm-1">
    <div class="container container--3xl">
        <section class="post__hero">
            <picture>
                <source srcset="<?= path_img() . esc($post['photo']) . '.webp' ?>" media="(min-width: 800px)">
                <img class="post__image" src="<?= path_img_tn() . esc($post['photo']) . '.webp' ?>" alt="Post Photo" loading="lazy">
            </picture>
            <h1 class="post__title mb-0"><?= esc($post['title']) ?></h1>
        </section>
    </div>

    <?php if (!empty($post['avatar'])):?>
        <div class="post__author">
            <img class="post__author-img" src="<?=path_avatar().pathinfo($post['avatar'], PATHINFO_FILENAME).'.webp'?>" alt="Avatar" loading="lazy">
            <p class="post__author-info">γράφει ο:<br> <a href="<?= site_url('author/' . esc($post['user_handle'])) ?>"><?= esc($post['author']) ?></a></p>
        </div>
    <?php endif;?>

    <div class="container container--xl">

        <?php if ($post['review']==1):?>
            <div class="post__warning">
                <p>Το παρόν δημοσίευμα φέρει τη σήμανση "Needs Review", γεγονός που υποδηλώνει ότι ενδέχεται να λείπουν φωτογραφίες, να υπάρχουν μη λειτουργικά βίντεο ή να περιλαμβάνονται πληροφορίες που χρήζουν διόρθωσης. Σας ευχαριστούμε για την κατανόησή σας έως ότου ολοκληρωθεί η απαραίτητη επιμέλεια του άρθρου.</p>
            </div>
        <?php endif;?>


        <section class="post__body mt-2 mb-7">

            <?php if (!empty($post['subtitle'])):?>
                <p><?= esc($post['subtitle']) ?></p>
            <?php endif;?>

            <?= esc($post['body'], 'raw') ?>
        </section>
    </div>

    <?= $this->include('components/share') ?>
    <?= $this->include('components/post_info') ?>

</article>

<div class="container container--xl mb-5">
    <h2 class="h1 plain-list-title">Related</h2>
    <?= view('components/plain_list', ['posts' => $related, 'style' => 'plain-list--columns']) ?>
</div>

<!--</?= $this->include('components/ai_knowledge') ?>-->

<?= $this->endSection() ?>
