<header class="dash-page-header">
    <div>
        <h1 class="ff-body fw-500 ls-1 mb-0">Browsers</h1>
        <p class="color-300 mb-0 lh-150">Get detailed insights into the browsers and versions your audience prefers, along with visit counts, unique users, device usage, and last activity.</p>
    </div>
</header>


<section class="grid grid-col-2 gap-05 grid-break-md mt-2">

    <div class="chart-container mb-5">
        <h4>Top 10 Browsers</h4>
        <canvas class="dash-chart" data-json="<?=chart_data($traffic['chart_browsers'])?>" data-type="pie"></canvas>
    </div>

    <div class="chart-container mb-5">
        <h4>Top 10 Browsers</h4>
        <canvas class="dash-chart" data-json="<?=chart_data($traffic['chart_browsers'])?>" data-type="bar"></canvas>
    </div>

    <panel class="tabpanel grid-col-span-2">
        <h3 class="tabpanel__title">Browsers</h3>
        <p class="tabpanel__desc">Find out which browsers your audience uses most frequently.</p>

        <?php if (!empty($traffic['browsers'])): ?>
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>Browser</th>
                        <th>Version</th>
                        <th>Visits</th>
                        <th>Unique Visitors</th>
                        <th>Mobile</th>
                        <th>Desktop</th>
                        <th>%</th>
                        <th>Last Visit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($traffic['browsers'] as $row): ?>
                        <tr>
                            <td><?= esc($row['browser']) ?></td>
                            <td class="primary"><?= esc($row['major_version']) ?></td>
                            <td class="primary"><?= esc($row['visits']) ?></td>
                            <td><?= esc($row['unique_visitors']) ?></td>
                            <td><?= esc($row['mobile_visits']) ?></td>
                            <td><?= esc($row['desktop_visits']) ?></td>
                            <td class="primary"><?= esc($row['perc']) ?></td>
                            <td class="primary"><?= esc($row['last_visit']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No browser data found.</p>
        <?php endif; ?>

    </panel>


</section>