<?php if (file_exists(FCPATH . 'audio/' . 'post_' . esc($post['id']) . '.mp3')): ?>

    <div class="container container--xs">

        <section class="post-reader">
            <h5 class="post-reader__title">Διάβασε το άρθρο για μένα..</h5>
            <audio class="post-reader__audio" controls preload="metadata" controlslist="nodownload noplaybackrate">
                <source src="<?=path_audio() . 'post_' . esc($post['id']) . '.mp3'?>" type="audio/mpeg">
            </audio>
        </section>

    </div>

<?php endif;?>
