<section class="relative border-t-4 border-b-4 border-secondary" data-js="magnetic-slider">

    <button class="btn btn-circle absolute left-2 top-1/2 z-20 hidden -translate-y-1/2 sm:flex" type="button" data-slider="prev" aria-label="Previous">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
        </svg>
    </button>
    <button class="btn btn-circle absolute right-2 top-1/2 z-20 hidden -translate-y-1/2 sm:flex" type="button" data-slider="next" aria-label="Next">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
    </button>

    <ul class="no-scrollbar flex gap-4 overflow-x-auto overflow-y-hidden snap-x snap-mandatory scroll-smooth px-3 py-2 touch-pan-x overscroll-x-contain sm:gap-6 sm:px-4">
        <?php foreach ($posts as $post):?>
            <li class="relative aspect-square w-[80vw] shrink-0 snap-center lg:w-[400px] 2xl:w-[512px]">
                <a class="group absolute inset-0" href="<?= site_url('post/' . esc($post['id'])) ?>" aria-label="<?=esc($post['title'])?>">
                    <h3 class="absolute bottom-0 left-0 right-0 z-10 p-5 text-white text-2xl lg:text-3xl 2xl:text-4xl font-semibold"><?=esc($post['title'])?></h3>
                    <figure class="absolute inset-0 -z-10">
                        <img class="h-full w-full object-cover" src="<?= path_img_tn() . esc($post['photo']) . '.webp' ?>" alt="<?=esc($post['title'])?>" loading="lazy">
                    </figure>
                    <span class="absolute inset-0 -z-5 bg-black/40 transition-opacity duration-300 group-hover:opacity-20"></span>
                </a>
            </li>
        <?php endforeach;?>
    </ul>

</section>
