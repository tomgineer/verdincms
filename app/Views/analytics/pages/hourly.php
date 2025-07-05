<header class="dash-page-header">
    <div>
        <h1 class="ff-body fw-500 ls-1 mb-0">Hourly Traffic</h1>
        <p class="color-300 mb-0 lh-150">See how traffic is distributed throughout the day and discover which hours attract the most visitors.</p>
    </div>
</header>

<section class="grid grid-col-2 gap-05 grid-break-md mt-2">

    <div class="chart-container mb-5">
        <h4>Hourly Traffic</h4>
        <canvas class="dash-chart" data-json="<?=chart_data($hourly['chart_hourly'])?>" data-type="line" data-color="red"></canvas>
    </div>

    <div class="chart-container mb-5">
        <h4>Peak Visiting Times</h4>
        <canvas class="dash-chart" data-json="<?=chart_data($hourly['chart_peak'])?>" data-type="bar" data-color="blue"></canvas>
    </div>

    <panel class="tabpanel">
        <h3 class="tabpanel__title">Hourly Traffic</h3>
        <p class="tabpanel__desc">View the number of visits received during each hour of the day.</p>

        <?php if (!empty($hourly['stats']['hourly_traffic'])): ?>
            <table class="dash-table dash-table--centered">
                <thead>
                    <tr>
                        <th>Hour</th>
                        <th>Visits</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($hourly['stats']['hourly_traffic'] as $row): ?>
                        <tr>
                            <td class="primary"><?= esc($row['f_hour']) ?></td>
                            <td><?= esc($row['cnt']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hourly traffic data found.</p>
        <?php endif; ?>

    </panel>

    <panel class="tabpanel tabpanel--right tabpanel--light">
        <h3 class="tabpanel__title">Peak Visiting Times</h3>
        <p class="tabpanel__desc">Identify the hours when your site experiences the highest traffic.</p>

        <?php if (!empty($hourly['stats']['peak_hours'])): ?>
            <table class="dash-table dash-table--centered">
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Hour</th>
                        <th>Visits</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($hourly['stats']['peak_hours'] as $index => $row): ?>
                        <tr>
                            <td class="primary"><?= ($index + 1) ?></td>
                            <td class="primary"><?= esc($row['f_hour']) ?></td>
                            <td><?= esc($row['cnt']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No peak hour data found.</p>
        <?php endif; ?>

    </panel>

</section>
