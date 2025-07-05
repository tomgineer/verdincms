<header class="dash-page-header">
    <div>
        <h1 class="ff-body fw-500 ls-1 mb-0">Visitors & Hits</h1>
        <p class="color-300 mb-0 lh-150">See how many users visit your site and how often pages and resources are accessed each day.</p>
    </div>
</header>

<section class="grid grid-col-2 gap-05 grid-break-md mt-2">

    <div class="chart-container mb-5">
        <h4>Visitors — Last 30 Days</h4>
        <canvas class="dash-chart" data-json="<?=chart_data($traffic['chart_visitors'])?>" data-type="line" data-color="red"></canvas>
    </div>

    <div class="chart-container mb-5">
        <h4>Hits — Last 30 Days</h4>
        <canvas class="dash-chart" data-json="<?=chart_data($traffic['chart_hits'])?>" data-type="line" data-color="blue"></canvas>
    </div>

    <panel class="tabpanel">
        <h3 class="tabpanel__title">Unique Visitors</h3>
        <p class="tabpanel__desc">Number of individual users who visited your site each day.</p>
        <?php if (!empty($traffic['stats']['visitors'])): ?>
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Visitors</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($traffic['stats']['visitors'] as $row): ?>
                        <tr>
                            <td class="primary"><?= esc($row['f_created']) ?></td>
                            <td><?= esc($row['cnt']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No visitor stats found.</p>
        <?php endif; ?>


    </panel>

    <panel class="tabpanel tabpanel--right tabpanel--light">
        <h3 class="tabpanel__title">Hits</h3>
        <p class="tabpanel__desc">Total number of pages or resources loaded during visits.</p>

        <?php if (!empty($traffic['stats']['hits'])): ?>
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Hits</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($traffic['stats']['hits'] as $row): ?>
                        <tr>
                            <td class="primary"><?= esc($row['f_created']) ?></td>
                            <td><?= esc($row['cnt']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hit stats found.</p>
        <?php endif; ?>

    </panel>


</section>