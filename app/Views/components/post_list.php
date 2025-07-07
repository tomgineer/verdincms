<section>

    <ul class="post-list <?=(!empty($ranked)?'ranked':'')?>">
        <?php foreach ($posts['posts'] as $post):?>
            <li class="mb-10">

                <div class="card lg:card-side bg-base-100">
                    <figure class="w-full lg:w-1/3">
                        <a href="<?=site_url('post/'. esc($post['id']))?>">
                            <img class="rounded-[25%_0_25%_0] shadow-md transition-all duration-300 ease-in-out hover:scale-105 hover:brightness-110 hover:shadow-xl" src="<?= path_img_tn() . esc($post['photo']) . '.webp' ?>" alt="Post Photo" loading="lazy">
                        </a>
                    </figure>

                    <div class="card-body w-full lg:w-2/3">

                        <a class="mb-2 hover:underline" href="<?=site_url('post/'. esc($post['id']))?>">
                            <h2 class="card-title text-2xl font-medium"><?=esc($post['title'])?></h2>
                        </a>

                        <p class="text-lg"><?=esc($post['subtitle'])?></p>

                        <div class="card-actions justify-end">
                            <a class="text-secondary hover:underline" href="<?=site_url('author/'. esc($post['author_handle']))?>"><?=esc($post['author'])?></a>
                            / <?=esc($post['ago'])?> in
                            <a class="text-secondary hover:underline" href="<?=site_url('topic/'. esc($post['topic_slug']))?>"><?=esc($post['topic'])?></a>
                        </div>
                    </div>
                </div>


            </li>
        <?php endforeach;?>
    </ul>

</section>