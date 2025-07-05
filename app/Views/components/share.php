<section class="share mb-5">

    <img class="share__img" src="<?=path_gfx().'monsters/monster1.svg?v=3'?>" alt="Monster" loading="lazy">

    <div class="container">
        <h2 class="share__title h1">Please Share!</h2>

        <div class="share__toolbar">
            <input class="share__input" type="text" value="<?=site_url('post/'.$post['id'])?>" readonly data-share-url="<?=site_url('post/'.$post['id'])?>">

            <div class="share__buttons">
                <button class="share__button" data-share-button>
                    <svg class="svg-icon" aria-hidden="true">
                        <use href="<?=svg("copy")?>"></use>
                    </svg>
                    <span>Copy</span>
                </button>
                <a class="share__button" href="<?=site_url('print/'.$post['id'])?>" target="_blank">
                    <svg class="svg-icon" aria-hidden="true">
                        <use href="<?=svg("print")?>"></use>
                    </svg>
                    <span>Print</span>
                </a>

            </div>
        </div>

    </div>

</section>
