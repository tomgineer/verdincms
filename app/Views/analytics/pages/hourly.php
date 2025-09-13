<header class="mt-10 mb-4">
    <h1 class="text-5xl mb-2">Hourly Traffic</h1>
    <p class="text-base-content/70">See how traffic is distributed throughout the day and discover which hours attract the most visitors.</p>
</header>

<section class="grid grid-cols-2 gap-8 mb-12">
    <div class="chart-container h-[40vh]">
        <h4>Hourly Traffic</h4>
        <canvas
            class="dash-chart"
            data-json="<?= chart_data($hourly['chart_hourly']) ?>"
            data-type="line"
            data-color="red"></canvas>
    </div>

    <div class="chart-container h-[40vh]">
        <h4>Peak Visiting Times</h4>
        <canvas
            class="dash-chart"
            data-json="<?= chart_data($hourly['chart_peak']) ?>"
            data-type="bar"
            data-color="blue"></canvas>
    </div>
</section>

<section class="grid grid-cols-2 gap-8">
    <div class="p-4">
        <h3 class="text-3xl mb-1">Hourly Traffic</h3>
        <p class="text-base-content/70 mb-4">View the number of visits received during each hour of the day.</p>

        <?php if (!empty($hourly['stats']['hourly_traffic'])): ?>
            <table class="table table-zebra-soft">
                <thead>
                    <tr>
                        <th>Hour</th>
                        <th>Visits</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($hourly['stats']['hourly_traffic'] as $row): ?>
                        <tr>
                            <td><?= esc($row['f_hour']) ?></td>
                            <td><?= esc($row['cnt']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hourly traffic data found.</p>
        <?php endif; ?>
    </div>

    <div class="p-4">
        <h3 class="text-3xl mb-1">Peak Visiting Times</h3>
        <p class="text-base-content/70 mb-4">Identify the hours when your site experiences the highest traffic.</p>

        <?php if (!empty($hourly['stats']['peak_hours'])): ?>
            <table class="table table-zebra-soft">
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
                            <td><?= ($index + 1) ?></td>
                            <td><?= esc($row['f_hour']) ?></td>
                            <td><?= esc($row['cnt']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No peak hour data found.</p>
        <?php endif; ?>
    </div>
</section>
