<?= $this->include('dashboard/pages/logs/header') ?>

<section class="grid grid-col-1 gap-05 mt-2">

    <panel class="tabpanel">

        <header class="flex flex-space gap-2 flex-vt">
            <div>
                <h3 class="tabpanel__title">Cron Jobs</h3>
                <p class="tabpanel__desc">Scheduled tasks and background script logs.</p>
            </div>
            <button class="btn-outline fs-200" data-dash-action="emptyCronLog" data-dash-return="logs/cron">
                <svg class="svg-icon" aria-hidden="true">
                    <use href="#mop"></use>
                </svg>
                Clear Cron History
            </button>
        </header>

        <?php if (!empty($crons)): ?>
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Type</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($crons as $item): ?>
                        <tr>
                            <td><?= esc($item['id']) ?></td>
                            <td><?= esc($item['cron_date']) ?></td>
                            <td><?= esc($item['cron_time']) ?></td>
                            <td><?= esc($item['type']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No cron logs found.</p>
        <?php endif; ?>
    </panel>

</section>



