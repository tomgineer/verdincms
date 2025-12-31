<div
    class="hero min-h-[50vh] md:min-h-[65vh] overflow-hidden relative bg-black bg-left lg:bg-center"
    style="background-image: url(<?= path_blocks() . $frontpage['hero']['image'] ?>);">

    <div class="absolute inset-0 bg-gradient-to-b from-black/25 via-black/10 to-black/55"></div>
    <div class="absolute inset-0 pointer-events-none bg-gradient-to-l from-black/15 via-black/35 to-transparent"></div>

    <div class="hero-content relative z-10 w-full px-6 py-12">
        <div class="flex w-full justify-end">
            <div class="max-w-2xl text-left">
                <p class="tracking-[0.25em] text-sm text-white/70 mb-2">
                    <?= esc($frontpage['hero']['text1']) ?>
                </p>

                <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight leading-tight drop-shadow-lg text-white">
                    <?= esc($frontpage['hero']['title']) ?>
                </h1>

                <div class="mt-6 prose prose-lg md:prose-xl text-white prose-p:leading-snug">
                    <?= $frontpage['hero']['body'] ?>
                </div>

                <a
                    href="<?= $frontpage['hero']['link1'] ?>"
                    class="inline-flex items-center justify-center
                            mt-8 px-10 py-4 text-lg font-semibold text-white
                            rounded-full
                            bg-gradient-to-r from-[#ff7a6c] via-[#ed5858] to-[#b53b3b]
                            shadow-2xl shadow-[#ed5858]/30
                            transition-all duration-300 ease-out
                            hover:scale-[1.03]
                            hover:shadow-[#ed5858]/50
                            hover:brightness-110">
                    <?= esc($frontpage['hero']['subtitle']) ?>
                </a>


            </div>
        </div>
    </div>
</div>