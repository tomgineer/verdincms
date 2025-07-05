<sidebar class="edit-sidebar-left">
    <a href="<?=base_url()?>"><img class="edit-sidebar-left__logo" src="<?=path_gfx().'verdincms.svg'?>" alt="VerdinCMS Logo"></a>

    <div class="edit-photo mt-2" data-type="<?=esc($type)?>">
        <input type="file" id="photoInput" accept="image/*" class="hidden">
    </div>

    <?= $this->include('edit/components/info_panel') ?>
    <?= $this->include('edit/components/options_panel') ?>
</sidebar>
