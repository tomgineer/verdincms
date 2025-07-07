<section class="footer footer-horizontal footer-center bg-base-200 text-base-content rounded p-10 mt-16">
    <nav class="flex flex-wrap gap-4 justify-center">
        <?php foreach ($topics_list as $topic):?>
            <a class="btn btn-secondary btn-dash btn-small" href="<?=site_url('topic/'.$topic['slug'])?>" data-match="<?='topic/'.$topic['slug']?>"><?=$topic['title']?></a>
        <?php endforeach;?>
    </nav>
</section>

<section class="footer sm:footer-horizontal bg-base-200 text-base-content p-10 pt-1">

    <nav>
        <h6 class="text-lg text-primary">Stats</h6>
        <p><span class="text-base-content/70">Total posts:</span> <?=esc($total_posts)?></p>
        <p><span class="text-base-content/70">Public posts:</span> <?=esc($public_posts)?></p>
        <p><a href="https://github.com/tomgineer/verdincms" target="_blank" class="link-hover text-base-content/70">VerdinCMS version:</a> <?=setting('system.version')?></p>
        <p><span class="text-base-content/70">Rendered in:</span> {elapsed_time} sec</p>
    </nav>

    <?php foreach ($pages_list as $sectionName => $pages):?>
        <nav>
            <h6 class="text-lg text-primary"><?=$sectionName?></h6>
            <?php foreach ($pages as $page):?>
                <?php if ( empty($page['url']) ):?>
                    <a class="link link-hover" href="<?=site_url($page['s_slug'].'/'.$page['slug'])?>" data-match="<?=$page['s_slug'].'/'.$page['slug']?>"><?=$page['label']?></a>
                <?php else:?>
                    <a class="link link-hover" href="<?=$page['url']?>" data-match="<?=$page['slug']?>"><?=$page['label']?></a>
                <?php endif;?>
            <?php endforeach;?>
        </nav>
    <?php endforeach;?>

</section>

<section class="footer bg-base-200 text-base-content border-base-300 border-t px-10 py-4 pb-8">
    <aside class="grid-flow-col gap-4 items-center">
        <a href="<?=base_url()?>">
            <img class="h-20" src="<?=path_gfx().'logo_color.svg'?>" alt="Logo Color" loading="lazy">
        </a>
        <div>
            <?=block($base_blocks,'footer','footer_copyright','body')?>
        </div>
    </aside>

    <nav class="md:place-self-center md:justify-self-end">
        <div class="grid grid-flow-col gap-4">
            <?php foreach ($socials_list as $social):?>
                <a class="hover:text-secondary" href="<?=$social['value']?>" target="_blank" rel="nofollow" title="<?=ucfirst($social['setting'])?>">
                    <svg class="svg-icon svg-icon-2x" aria-hidden="true">
                        <use href="<?=svg($social['setting'])?>"></use>
                    </svg>
                </a>
            <?php endforeach;?>
        </div>
    </nav>

</section>