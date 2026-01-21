<?php if (!empty($pages)): ?>
    <section>
        <ul>
            <?php foreach ($pages as $page): ?>
                <li class="mb-12">
                    <div class="card lg:card-side rounded-none">
                        <figure class="w-full lg:w-1/3 my-1">
                            <a class="w-full" href="<?= site_url('admin/edit/page/' . esc($page['id'])) ?>">
                                <img
                                    class="rounded-[25%_0_25%_0] lg:shadow-sm w-full aspect-square hover:scale-95 hover:brightness-110 hover:shadow-xl hover:transition-all hover:duration-300 hover:ease-in-out"
                                    src="<?= path_img_tn() . esc($page['photo']) . '.webp' ?>"
                                    alt="<?= esc($page['title']) ?>"
                                    loading="lazy">
                            </a>
                        </figure>

                        <div class="card-body w-full lg:w-2/3 px-0 md:px-6">
                            <a class="mb-2 link link-hover" href="<?= site_url('admin/edit/page/' . esc($page['id'])) ?>">
                                <h2 class="card-title text-2xl font-medium"><?= esc($page['title']) ?></h2>
                            </a>

                            <p class="text-lg prose"><?= esc($page['subtitle']) ?></p>

                            <div class="card-actions justify-end">
                                <span class="text-secondary"><?= esc($page['author']) ?></span>
                                <span class="text-base-content/50">/ <?= esc($page['ago']) ?></span>
                                <span class="badge badge-dash badge-accent"><?= esc($page['section']) ?></span>
                            </div>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
<?php else: ?>
    <p>No pages found.</p>
<?php endif; ?>
