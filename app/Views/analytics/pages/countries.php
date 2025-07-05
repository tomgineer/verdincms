<header class="dash-page-header">
    <div>
        <h1 class="ff-body fw-500 ls-1 mb-0">Countries</h1>
        <p class="color-300 mb-0 lh-150">Discover your audience's global reach with a breakdown of visits by country.</p>
    </div>
</header>

<section class="grid grid-col-2 gap-05 mt-2">

    <div class="chart-container mb-5">
        <h4>Top 10 Countries — Pie Chart</h4>
        <canvas class="dash-chart" data-json="<?=chart_data($traffic['chart_countries'])?>" data-type="pie" data-color="red"></canvas>
    </div>

    <div class="chart-container mb-5">
        <h4>Top 10 Countries — Bar Chart</h4>
        <canvas class="dash-chart" data-json="<?=chart_data($traffic['chart_countries'])?>" data-type="bar" data-color="red"></canvas>
    </div>

    <panel class="tabpanel grid-col-span-2">
        <h3 class="tabpanel__title">Countries</h3>
        <p class="tabpanel__desc">See where your visitors are coming from around the world.</p>

        <?php if (!empty($traffic['countries'])): ?>
            <table class="dash-table dash-table--centered">
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
                            <td class="image">
                                <img src="<?= path_gfx().'flags/regular/'.strtolower($row['country_code']).'.svg' ?>">
                            </td>
                            <td><?= esc($row['country']) ?></td>
                            <td class="primary"><?= esc($row['country_code']) ?></td>
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
            <p>No country data found.</p>
        <?php endif; ?>

    </panel>


</section>