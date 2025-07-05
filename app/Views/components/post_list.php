<section>

    <ul class="post-list <?=(!empty($ranked)?'ranked':'')?>">
        <?php foreach ($posts['posts'] as $post):?>
            <li class="post-list__item">
                <a class="post-list__image-link" href="<?=site_url('post/'. esc($post['id']))?>">
                    <picture>
                        <source srcset="<?= path_img_xs() . esc($post['photo']) . '.webp' ?>" media="(min-width: 800px)">
                        <img class="post-list__image" src="<?= path_img_tn() . esc($post['photo']) . '.webp' ?>" alt="Post Photo" loading="lazy">
                    </picture>
                </a>

                <div class="post-list__body">
                    <a class="post-list__link" href="<?=site_url('post/'. esc($post['id']))?>">
                        <h2 class="post-list__title"><?=esc($post['title'])?></h2>
                    </a>

                    <p class="post-list__info">
                        <a href="<?=site_url('author/'. esc($post['author_handle']))?>"><?=esc($post['author'])?></a>
                        / <?=esc($post['f_created'])?> in
                        <a href="<?=site_url('topic/'. esc($post['topic_slug']))?>"><?=esc($post['topic'])?></a>
                    </p>
                </div>

            </li>
        <?php endforeach;?>
    </ul>

</section>