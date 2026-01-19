<section>

    <ul>
        <?php foreach ($posts as $post): ?>
            <li class="mb-12">

                <div class="card lg:card-side rounded-none">
                    <figure class="w-full lg:w-1/3 my-1">
                        <a class="w-full" href="<?= site_url('post/' . esc($post['id'])) ?>">
                            <img
                                class="rounded-[25%_0_25%_0] lg:shadow-sm w-full aspect-square hover:scale-95 hover:brightness-110 hover:shadow-xl hover:transition-all hover:duration-300 hover:ease-in-out"
                                src="<?= path_img_tn() . esc($post['photo']) . '.webp' ?>"
                                alt="<?= esc($post['title']) ?>"
                                loading="lazy">
                        </a>
                    </figure>

                    <div class="card-body w-full lg:w-2/3 px-0 md:px-6">

                        <a class="mb-2 link link-hover" href="<?= site_url('post/' . esc($post['id'])) ?>">
                            <h2 class="card-title text-2xl font-medium"><?= esc($post['title']) ?></h2>
                        </a>

                        <p class="text-lg prose"><?= esc($post['subtitle']) ?></p>

                        <div class="card-actions justify-end">
                            <a class="text-secondary hover:underline" href="<?= site_url('author/' . esc($post['author_handle'])) ?>"><?= esc($post['author']) ?></a>
                            <span class="text-base-content/50">/ <?= esc($post['ago']) ?> <?= lang('App.in') ?></span>
                            <a class="text-secondary hover:underline" href="<?= site_url('topic/' . esc($post['topic_slug'])) ?>"><?= esc($post['topic']) ?></a>
                        </div>
                    </div>
                </div>


            </li>
        <?php endforeach; ?>
    </ul>

</section>
