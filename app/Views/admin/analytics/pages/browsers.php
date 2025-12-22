<header class="mt-10 mb-4">
    <h1 class="text-5xl mb-2">Browsers</h1>
    <p class="text-base-content/70">Get detailed insights into the browsers and versions your audience prefers, along with visit counts, unique users, device usage, and last activity.</p>
</header>

<section class="grid grid-cols-2 gap-8 mb-12">
    <div class="chart-container h-[40vh]">
        <h4>Top 10 Browsers</h4>
        <canvas
            class="dash-chart"
            data-json="<?= chart_data($traffic['chart_browsers']) ?>"
            data-type="pie"></canvas>
    </div>

    <div class="chart-container h-[40vh]">
        <h4>Top 10 Browsers</h4>
        <canvas
            class="dash-chart"
            data-json="<?= chart_data($traffic['chart_browsers']) ?>"
            data-type="bar"></canvas>
    </div>
</section>

<section class="grid grid-cols-1 gap-8">
    <div class="p-4">
        <h3 class="text-3xl mb-1">Browsers</h3>
        <p class="text-base-content/70 mb-4">Find out which browsers your audience uses most frequently.</p>

        <?php if (!empty($traffic['browsers'])): ?>
            <table class="table table-zebra-soft">
                <thead>
                    <tr>
                        <th>Browser</th>
                        <th>Version</th>
                        <th class="text-right">Visits</th>
                        <th class="text-right">Unique Visitors</th>
                        <th class="text-right">Mobile</th>
                        <th class="text-right">Desktop</th>
                        <th class="text-right">%</th>
                        <th>Last Visit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($traffic['browsers'] as $row): ?>
                        <tr>
                            <td><?= esc($row['browser']) ?></td>
                            <td><?= esc($row['major_version']) ?></td>
                            <td class="text-right"><?= esc($row['visits']) ?></td>
                            <td class="text-right"><?= esc($row['unique_visitors']) ?></td>
                            <td class="text-right"><?= esc($row['mobile_visits']) ?></td>
                            <td class="text-right"><?= esc($row['desktop_visits']) ?></td>
                            <td class="text-right"><?= esc($row['perc']) ?></td>
                            <td><?= esc($row['last_visit']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No browser data found.</p>
        <?php endif; ?>
    </div>
</section>
