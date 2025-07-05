<section>
    <ul class="plain-list <?= $style ?? '' ?>">
        <?php foreach ($posts as $post):?>
            <li class="plain-list__item">
                <a class="plain-list__link" href="<?=site_url('post/'. esc($post['id']))?>">
                    <h4 class="plain-list__title"><?=esc($post['title'])?></h4>
                </a>

                <p class="plain-list__info">
                    <a href="<?=site_url('author/'. esc($post['author_handle']))?>"><?=esc($post['author'])?></a>
                    / <?=esc($post['f_created'])?> in
                    <a href="<?=site_url('topic/'. esc($post['topic_slug']))?>"><?=esc($post['topic'])?></a>
                </p>
            </li>
        <?php endforeach;?>
    </ul>
</section>
