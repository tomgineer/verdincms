<section class="<?= !empty($style) ? 'grid gap-x-4 md:grid-cols-2 xl:grid-cols-3' : '' ?>">
    <ul class="contents">
        <?php foreach ($posts as $post):?>
            <li class="mb-4 flex flex-col">

                <div class="card bg-base-200 card-md flex-1">
                    <div class="card-body">
                        <a class="mb-1 hover:underline" href="<?=site_url('post/'. esc($post['id']))?>">
                            <h2 class="card-title font-medium"><?=esc($post['title'])?></h2>
                        </a>
                        <p><?=esc($post['subtitle'])?></p>

                        <div class="card-actions justify-end">
                            <a class="text-secondary hover:underline" href="<?=site_url('author/'. esc($post['author_handle']))?>"><?=esc($post['author'])?></a>
                            <span class="text-base-content/50">/ <?=esc($post['ago'])?> <?=lang('misc.in')?></span>
                            <a class="text-secondary hover:underline" href="<?=site_url('topic/'. esc($post['topic_slug']))?>"><?=esc($post['topic'])?></a>
                        </div>
                    </div>
                </div>

            </li>
        <?php endforeach;?>
    </ul>
</section>
