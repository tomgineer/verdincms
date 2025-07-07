<section>
    <ul>
        <?php foreach ($posts as $post):?>
            <li class="mb-4">

                <div class="card bg-base-200 card-md">
                    <div class="card-body">
                        <a class="mb-1 hover:underline" href="<?=site_url('post/'. esc($post['id']))?>">
                            <h2 class="card-title font-medium"><?=esc($post['title'])?></h2>
                        </a>
                        <p><?=esc($post['subtitle'])?></p>

                        <div class="card-actions justify-end">
                            <a class="text-secondary hover:underline" href="<?=site_url('author/'. esc($post['author_handle']))?>"><?=esc($post['author'])?></a>
                            <span class="text-base-content/50">/ <?=esc($post['ago'])?> in</span>
                            <a class="text-secondary hover:underline" href="<?=site_url('topic/'. esc($post['topic_slug']))?>"><?=esc($post['topic'])?></a>
                        </div>
                    </div>
                </div>

            </li>
        <?php endforeach;?>
    </ul>
</section>
