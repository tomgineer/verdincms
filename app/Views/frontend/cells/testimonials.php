<?php
    /** @var array $testimonials */
    $intro = array_shift($testimonials);
?>
<section class="custom-bg-3 px-4 lg:px-12 py-12 lg:py-24" data-theme="<?= setting('theme.darkBlocks') ?>">
    <div class="max-w-7xl mx-auto">
        <div class="mb-8 max-w-3xl mx-auto">
            <div class="text-4xl text-center font-heading font-semibold [&_strong]:text-primary">
                <?= $intro['body']?>
            </div>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <?php foreach ($testimonials as $testimonial): ?>
                <div class="flex flex-col items-center bg-base-200 px-2 lg:px-8 py-6 lg:py-12 rounded-xl border-2 border-white/10">
                    <div class="relative">
                        <img class="w-24 rounded-full aspect-square mb-4" src="<?= path_blocks() . $testimonial['image'] ?>" loading="lazy">
                        <svg class="absolute top-0 -right-2 size-6 text-secondary" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="10.5" cy="10.5" r="8.5" fill="currentColor" />
                            <path d="m11.584 13.872 1.752-3.288 1.104-.288a2.7 2.7 0 0 1-.432.576.76.76 0 0 1-.552.24q-.672 0-1.248-.576t-.576-1.464q0-.936.624-1.584.648-.672 1.584-.672.888 0 1.536.672.672.648.672 1.584 0 .384-.168.912-.144.504-.576 1.296l-1.92 3.552zm-5.4 0 1.752-3.288 1.08-.288a2.2 2.2 0 0 1-.408.576.76.76 0 0 1-.552.24q-.696 0-1.272-.576t-.576-1.464q0-.936.624-1.584.648-.672 1.584-.672.888 0 1.536.672.672.648.672 1.584 0 .384-.144.912-.144.504-.576 1.296L7.96 14.832z" fill="#fff" />
                        </svg>
                    </div>
                    <div class="text-base-content/70 mb-4 text-center"><?= $testimonial['body'] ?></div>
                    <h3 class="text-lg text-center"><?= esc($testimonial['title']) ?></h3>
                    <p class="text-xs text-base-content/70 text-center"><?= esc($testimonial['subtitle']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>
