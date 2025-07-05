<modal class="dash-modal dash-modal--xs hidden" data-modal="sortTopics" role="dialog" aria-modal="true">

    <h3 class="dash-modal__title mb-0">
        <svg class="svg-icon color-400" aria-hidden="true">
            <use href="#verdincms"></use>
        </svg>
        <span>Sort Topics</span>
    </h3>

    <button class="dash-modal__close" type="button" aria-label="Close">
        <svg class="svg-icon" aria-hidden="true">
            <use href="#nav-close"></use>
        </svg>
    </button>

    <sortbuilder class="sortbuilder">
        <?=view('components/sortbuilder', $data_sort_topics)?>
    </sortbuilder>

</modal>
