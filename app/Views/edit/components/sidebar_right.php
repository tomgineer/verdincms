<sidebar class="edit-sidebar-right">
    <?= $this->include('edit/components/actions') ?>

    <div class="range-slider mt-2">
        <svg class="svg-icon range-slider__icon" aria-hidden="true">
            <use href="#font-size"></use>
        </svg>
        <input class="range-slider__input" type="range" min="1" max="20" value="1" data-edit-font-size>
        <span class="range-slider__progress">1</span>
    </div>

    <?= $this->include('edit/components/settings_panel') ?>
    <?= $this->include('edit/components/ai_panel') ?>
</sidebar>