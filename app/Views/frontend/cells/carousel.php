<?php if (!empty($posts)): ?>
    <section class="carousel-wrapper relative hidden lg:block">
        <div class="carousel gap-2 border-t-4 border-b-4 border-secondary py-2 flex max-w-full">

            <?php foreach ($posts as $post): ?>
                <div class="carousel-item">

                    <a
                        class="group relative w-[80vw] lg:w-[380px] 2xl:w-[450px] aspect-square"
                        href="<?= site_url('post/' . esc($post['id'])) ?>"
                        aria-label="<?= esc($post['title']) ?>">
                        <h3
                            class="absolute bottom-0 left-0 right-0 z-10 p-5
                            text-white text-xl lg:text-2xl 2xl:text-3xl font-semibold">
                            <?= esc($post['title']) ?>
                        </h3>
                        <figure class="absolute inset-0 -z-10">
                            <img
                                class="h-full w-full object-cover"
                                src="<?= base_url('images/') . esc($post['photo']) . '.webp' ?>"
                                alt="<?= esc($post['title']) ?>"
                                loading="lazy">
                        </figure>
                        <span class="absolute inset-0 -z-5 bg-black/40 transition-opacity duration-300 group-hover:opacity-20"></span>
                    </a>

                </div>
            <?php endforeach; ?>
        </div>

        <button
            class="carousel-left btn btn-circle btn-neutral opacity-65 hover:opacity-100
            absolute left-2 top-1/2 transform -translate-y-1/2 z-20 hidden 2xl:flex">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
            </svg>
        </button>

        <button
            class="carousel-right btn btn-circle btn-neutral opacity-65 hover:opacity-100
            absolute right-2 top-1/2 transform -translate-y-1/2 z-20 hidden 2xl:flex">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
        </button>
    </section>
<?php endif; ?>