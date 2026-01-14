<section class="bg-gradient-to-br from-primary via-primary/70 to-secondary text-base-content" data-theme="<?=setting('theme.darkBlocks')?>">
    <div class="max-w-5xl mx-auto px-8 py-16 flex flex-col md:flex-row items-center gap-12">

        <div class="flex-1 text-center md:text-left">
            <h1 class="text-4xl md:text-5xl font-bold mb-6 text-base-content">
                <?=esc($title)?>
            </h1>
            <div class="text-lg leading-relaxed">
               <?=$body?>
            </div>
        </div>

        <form
            id="newsletter-form"
            class="flex-1 w-full max-w-md bg-base-200/20 backdrop-blur-lg rounded-2xl p-6 shadow-xl flex flex-col gap-4">
            <input type="text" name="hp_newsletter" class="hidden" autocomplete="off" tabindex="-1" aria-hidden="true">

            <input
                type="email"
                name="email"
                placeholder="<?=esc($subtitle)?>"
                class="input input-lg w-full bg-transparent border-0 border-b-2 border-base-content/30 rounded-none
               focus:border-accent focus:outline-none text-base-content placeholder:text-base-content/50 transition-all duration-200"
                required />

            <button type="submit" class="btn btn-primary btn-lg w-full shadow-md hover:shadow-accent/30 transition-all duration-200">
                <?=esc($text2)?>
            </button>

            <p id="newsletter-message" class="text-sm text-center max-w-2xs mx-auto text-wrap">
                <?=esc($text1)?>
            </p>
        </form>

    </div>
</section>