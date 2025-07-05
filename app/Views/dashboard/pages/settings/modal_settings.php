<modal class="dash-modal dash-modal--lg hidden" data-modal="modalSettings" role="dialog" aria-modal="true">

    <h3 class="dash-modal__title mb-1 no-select">
        <svg class="svg-icon color-400" aria-hidden="true">
            <use href="#verdincms"></use>
        </svg>
        <span>Edit Setting</span>
    </h3>
    <button class="dash-modal__prev" type="button" aria-label="Previous">
        <svg class="svg-icon" aria-hidden="true">
            <use href="#chevron-prev"></use>
        </svg>
    </button>
    <button class="dash-modal__next" type="button" aria-label="Next">
        <svg class="svg-icon" aria-hidden="true">
            <use href="#chevron-next"></use>
        </svg>
    </button>
    <button class="dash-modal__close" type="button" aria-label="Close">
        <svg class="svg-icon" aria-hidden="true">
            <use href="#nav-close"></use>
        </svg>
    </button>

    <formbuilder class="formbuilder" data-formbuilder-table="<?=$modal_data['table']?>">
        <?= $this->include('components/formbuilder/header') ?>

        <section class="formbuilder__section form-settings">
            <?=view('components/formbuilder/formbuilder', $modal_data)?>
        </section>

        <?= $this->include('components/formbuilder/footer') ?>
    </formbuilder>

</modal>

<backdrop class="dash-modal__backdrop hidden"></backdrop>