<section class="footer grid grid-break-sm gap-5vw">
    <div class="footer__copy">
        <a href="<?=base_url()?>">
            <img class="footer__logo mb-1 mt-sm-2" src="<?=path_gfx().'logo_color.svg'?>" alt="Logo" loading="lazy">
        </a>
        <div class="fs-200"><?=block($base_blocks,'footer','footer_copyright','body')?></div>
        <p class="fs-200">Total posts: <span><?=esc($total_posts)?></span></p>
        <p class="fs-200">Public posts: <span><?=esc($public_posts)?></span></p>
        <p class="fs-200">VerdinCMS version: <span><?=setting('version')?></span></p>
        <p class="fs-200">Rendered in: <span>{elapsed_time} sec</span></p>

        <div class="flex flex-wrap pt-075 gap-075">
            <?php foreach ($socials_list as $social):?>
                <a class="footer__social-link" href="<?=$social['value']?>" target="_blank" rel="nofollow" title="<?=ucfirst($social['setting'])?>">
                    <svg class="svg-icon svg-icon-xl" aria-hidden="true">
                        <use href="<?=svg($social['setting'])?>"></use>
                    </svg>
                </a>
            <?php endforeach;?>
        </div>
    </div>

    <div>
        <nav class="footer__nav" data-nav-active="<?=get_route()?>">
            <div>
                <h4 class="footer__nav-title">Topics</h4>
                <?php foreach ($topics_list as $topic):?>
                    <ul class="footer__nav-list">
                        <li>
                            <a class="footer__nav-link" href="<?=site_url('topic/'.$topic['slug'])?>" data-match="<?='topic/'.$topic['slug']?>"><?=$topic['title']?></a>
                        </li>
                    </ul>
                <?php endforeach;?>
            </div>

            <?php foreach ($pages_list as $sectionName => $pages):?>
                <div>
                    <h4 class="footer__nav-title"><?=$sectionName?></h4>
                    <ul class="footer__nav-list">
                        <?php foreach ($pages as $page):?>
                            <li>
                                <?php if ( empty($page['url']) ):?>
                                    <a class="footer__nav-link" href="<?=site_url($page['s_slug'].'/'.$page['slug'])?>" data-match="<?=$page['s_slug'].'/'.$page['slug']?>"><?=$page['label']?></a>
                                <?php else:?>
                                    <a class="footer__nav-link" href="<?=$page['url']?>" data-match="<?=$page['slug']?>"><?=$page['label']?></a>
                                <?php endif;?>
                            </li>

                        <?php endforeach;?>
                    </ul>
                </div>
            <?php endforeach;?>
        </nav>
    </div>

    <div class="footer__up mt-sm-2">
        <a class="btn-up" href="#">
            <svg class="svg-icon svg-icon-4x" aria-hidden="true">
                <use href="<?=svg("arrow-up")?>"></use>
            </svg>
        </a>
    </div>

</section>