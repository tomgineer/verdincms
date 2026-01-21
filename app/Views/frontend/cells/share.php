<section class="bg-transparent text-white" data-theme="<?= setting('theme.darkBlocks') ?>">
    <div class="max-w-5xl mx-auto rounded lg:rounded-full overflow-hidden flex flex-col lg:flex-row items-center
        gap-4 px-4 lg:px-16 py-4 bg-gradient-to-br from-red-600 via-red-400 to-red-500">

        <div class="p-4">
            <h2 class="text-9xl tracking-tighter text-red-200">SHARE</h2>
        </div>

        <div class="p-4 flex flex-col gap-1">
            <h2 class="text-2xl"><?= esc($title) ?></h2>
            <div class="text-lg [&_p]:leading-snug"><?= $body ?></div>

            <h4 class="mt-2 text-red-100"><?= esc($subtitle) ?></h4>

            <div class="flex w-full">
                <input
                    type="text"
                    class="input input-ghost w-full font-mono focus:outline-none
                        bg-black/30 border-0 rounded-full rounded-r-none pl-5"
                    value="<?= current_url() ?>"
                    readonly>
                <button
                    type="button"
                    class="btn btn-ghost bg-black/50 border-0 rounded-full rounded-l-none pr-5"
                    data-js-copy-url>
                    <?= lang('App.copy') ?>
                </button>
            </div>
            <p class="text-sm text-red-100">
                <?= esc($text1) ?>
            </p>

        </div>
    </div>

</section>