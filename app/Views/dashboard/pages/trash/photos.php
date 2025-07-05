<?= $this->include('dashboard/pages/trash/header') ?>

<section class="grid grid-col-1 gap-05 mt-2">

    <panel class="tabpanel tabpanel">

        <header class="flex flex-space gap-2 flex-vt">
            <div>
                <h3 class="tabpanel__title">Orphan Photos</h3>
                <p class="tabpanel__desc">Images no longer linked to any post or page.</p>
            </div>
            <button class="btn-outline fs-200" data-dash-action="removeOrphanPhotos" data-dash-return="trash/photos">
                <svg class="svg-icon" aria-hidden="true">
                    <use href="#warning"></use>
                </svg>
                Purge Orphan Photos
            </button>
        </header>

        <div class="grid grid-col-auto-200 gap-col-1 gap-row-2">
            <?php if ( !empty($photos) ):?>

                <?php foreach ($photos as $photo):?>
                    <img class="dash-thumb" src="<?=path_img().$photo.'.webp'?>" alt="<?=$photo?>">
                <?php endforeach;?>

            <?php else:?>
                <p>No orphan photos found.</p>
            <?php endif;?>
        </div>

    </panel>

</section>

