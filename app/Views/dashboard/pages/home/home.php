<header class="dash-page-header">
    <div>
        <h1 class="ff-body fw-500 ls-1 mb-0">Welcome, <?=session('firstname')?>!</h1>
        <p class="color-300 mb-0 lh-150" data-dash-typewriter="How can I help you today?">&nbsp;</p>
    </div>
</header>

<section class="grid grid-col-2 gap-05 mt-2">

    <div class="chart-container mb-5">
        <h4>Visitors & Hits — Last 14 Days</h4>
        <canvas class="dash-chart" data-json="<?=chart_data($chart_visitors)?>" data-type="bar"></canvas>
    </div>

    <div class="chart-container mb-5">
        <h4>Posting Activity — Last 14 Days</h4>
        <canvas class="dash-chart" data-json="<?=chart_data($posting_activity)?>" data-type="bar"></canvas>
    </div>

    <panel class="tabpanel grid-row-span-2">

        <header class="flex flex-space gap-2 flex-vt">
            <div>
                <h3 class="tabpanel__title">Actions</h3>
                <p class="tabpanel__desc">System-level actions for maintenance, cleanup, and automated tasks. Use with care—these are powerful one-click operations.</p>
            </div>

            <button class="btn-outline fs-200 locked" data-protect="dash-actions">
                <svg class="svg-icon" aria-hidden="true">
                    <use href="#lock"></use>
                </svg>
                <span>Unlock</span>
            </button>
        </header>

        <div class="grid grid-col-auto-120 gap-075 dash-actions">
            <?php foreach ($actions as $item): ?>
                <button class="dash-btn disabled" data-dash-action="<?= esc($item['action']) ?>" type="button">
                    <svg class="svg-icon dash-btn__icon" aria-hidden="true">
                        <use href="#<?= esc($item['icon']) ?>"></use>
                    </svg>
                    <span class="dash-btn__label"><?= esc($item['title']) ?></span>
                </button>
            <?php endforeach; ?>
        </div>
    </panel>

    <panel class="tabpanel tabpanel--right tabpanel--light">
        <h3 class="tabpanel__title">Sort Items</h3>
        <p class="tabpanel__desc">Drag and drop items to set their new order.</p>

        <div class="grid grid-col-auto-120 gap-075">
            <?php foreach ($sortables as $item): ?>
                <button class="dash-btn" data-dash-sortable="<?= esc($item['action']) ?>" type="button">
                    <svg class="svg-icon dash-btn__icon" aria-hidden="true">
                        <use href="#<?= esc($item['icon']) ?>"></use>
                    </svg>
                    <span class="dash-btn__label"><?= esc($item['title']) ?></span>
                </button>
            <?php endforeach; ?>
        </div>

    </panel>

    <panel class="panel">
        <h3 class="panel__title">Admin Links</h3>
        <p class="panel__desc">Quick access to content creation, layout management, and system configuration tools.</p>

        <div class="grid grid-col-auto-120 gap-075">
            <?php foreach ($admin_links as $item): ?>
                <a class="dash-btn" href="<?=site_url($item['action'])?>" target="_blank">
                    <svg class="svg-icon dash-btn__icon" aria-hidden="true">
                        <use href="#<?= esc($item['icon']) ?>"></use>
                    </svg>
                    <span class="dash-btn__label"><?= esc($item['title']) ?></span>
                </a>
            <?php endforeach; ?>
        </div>
    </panel>



</section>

<?= $this->include('dashboard/pages/home/modal_sort_pages') ?>
<?= $this->include('dashboard/pages/home/modal_sort_topics') ?>
<?= $this->include('dashboard/pages/home/modal_sort_sections') ?>
<?= $this->include('dashboard/pages/home/modal_sort_settings') ?>
<backdrop class="dash-modal__backdrop hidden"></backdrop>