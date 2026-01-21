<section>
    <div class="max-w-3xl mx-auto border-t border-base-content/20 py-4">
        <h4 class="mb-4 text-accent"><?=lang('App.share')?></h4>
        <h3 class="text-2xl"><?= esc($title) ?></h3>
        <div class="prose max-w-none mb-4"><?=$body?></div>

        <div class="join w-full">
            <input class="input join-item w-full font-mono" type="text" value="<?=current_url()?>" readonly/>
            <button class="btn btn-accent join-item" type="button" data-js-copy-url><?=lang('App.copy')?></button>
        </div>

    </div>
</section>