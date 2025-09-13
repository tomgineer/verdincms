<header class="mt-10 mb-4">
    <h1 class="text-5xl mb-2">Countries</h1>
    <p class="text-base-content/70">Discover your audience's global reach with a breakdown of visits by country.</p>
</header>

<section class="grid grid-cols-2 gap-8 mb-12">
    <div class="chart-container">
        <h4>Top 10 Countries — Pie Chart</h4>
        <canvas
            class="dash-chart"
            data-json="<?= chart_data($traffic['chart_countries']) ?>"
            data-type="pie"
            data-color="red"></canvas>
    </div>

    <div class="chart-container">
        <h4>Top 10 Countries — Bar Chart</h4>
        <canvas
            class="dash-chart"
            data-json="<?= chart_data($traffic['chart_countries']) ?>"
            data-type="bar"
            data-color="red"></canvas>
    </div>
</section>

<section class="grid grid-cols-1 gap-8">
    <div class="p-4">
        <h3 class="text-3xl mb-1">Countries</h3>
        <p class="text-base-content/70 mb-4">See where your visitors are coming from around the world.</p>

        <?php if (!empty($traffic['countries'])): ?>
            <table class="table table-zebra-soft">
                <thead>
                    <tr>
                        <th>&nbsp;</th>
                        <th>Country</th>
                        <th>Code</th>
                        <th>Visits</th>
                        <th>Unique Visitors</th>
                        <th>Mobile</th>
                        <th>Desktop</th>
                        <th>%</th>
                        <th>Last Visit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($traffic['countries'] as $row): ?>
                        <tr>
                            <td>
                                <img
                                    src="<?= path_gfx().'flags/regular/'.strtolower($row['country_code']).'.svg' ?>"
                                    alt="<?= esc($row['country']) ?> flag"
                                    loading="lazy">
                            </td>
                            <td><?= esc($row['country']) ?></td>
                            <td><?= esc($row['country_code']) ?></td>
                            <td><?= esc($row['visits']) ?></td>
                            <td><?= esc($row['unique_visitors']) ?></td>
                            <td><?= esc($row['mobile_visits']) ?></td>
                            <td><?= esc($row['desktop_visits']) ?></td>
                            <td><?= esc($row['perc']) ?></td>
                            <td><?= esc($row['last_visit']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No country data found.</p>
        <?php endif; ?>
    </div>
</section>
