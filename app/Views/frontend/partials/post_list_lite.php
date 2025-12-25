<section class="<?= !empty($style) ? 'grid gap-x-4 md:grid-cols-2 xl:grid-cols-3' : '' ?>">
    <ul class="contents">
        <?php foreach ($posts as $post): ?>
            <li class="mb-4 flex flex-col">

                <div class="card bg-base-200 card-md flex-1">

                    <div class="card-body">

                        <a class="mb-1 link link-hover" href="<?= site_url('post/' . esc($post['id'])) ?>">
                            <h2 class="card-title font-medium"><?= esc($post['title']) ?></h2>
                        </a>
                        <div>
                            <figure class="w-16 xl:w-20 2xl:w-24 shrink-0 aspect-square rounded-full wrap-around">
                                <a href="<?= site_url('post/' . esc($post['id'])) ?>">
                                    <img
                                        src="<?= path_img_xs() . esc($post['photo']) . '.webp' ?>"
                                        class="h-full w-full object-cover"
                                        loading="lazy">
                                </a>
                            </figure>
                            <p><?= esc($post['subtitle']) ?></p>
                        </div>

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