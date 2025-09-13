<header class="mt-10 mb-4">
    <h1 class="text-5xl mb-2">Visitors & Hits</h1>
    <p class="text-base-content/70">See how many users visit your site and how often pages and resources are accessed each day.</p>
</header>

<section class="grid grid-cols-2 gap-8 mb-12">
    <div class="chart-container">
        <h4>Visitors — Last 30 Days</h4>
        <canvas class="dash-chart" data-json="<?=chart_data($traffic['chart_visitors'])?>" data-type="line" data-color="red"></canvas>
    </div>

    <div class="chart-container">
        <h4>Hits — Last 30 Days</h4>
        <canvas class="dash-chart" data-json="<?=chart_data($traffic['chart_hits'])?>" data-type="line" data-color="blue"></canvas>
    </div>
</section>

<section class="grid grid-cols-2 gap-8">

    <div class="p-4">
        <h3 class="text-3xl mb-1">Unique Visitors</h3>
        <p class="text-base-content/70 mb-4">Number of individual users who visited your site each day.</p>

        <?php if (!empty($traffic['stats']['visitors'])): ?>
            <table class="table table-zebra-soft">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Visitors</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($traffic['stats']['visitors'] as $row): ?>
                        <tr>
                            <td><?= esc($row['f_created']) ?></td>
                            <td><?= esc($row['cnt']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No visitor stats found.</p>
        <?php endif; ?>
    </div>

    <div class="p-4">
        <h3 class="text-3xl mb-1">Hits</h3>
        <p class="text-base-content/70 mb-4">Total number of pages or resources loaded during visits.</p>

        <?php if (!empty($traffic['stats']['hits'])): ?>
            <table class="table table-zebra-soft">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Hits</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($traffic['stats']['hits'] as $row): ?>
                        <tr>
                            <td><?= esc($row['f_created']) ?></td>
                            <td><?= esc($row['cnt']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hit stats found.</p>
        <?php endif; ?>
    </div>

</section><!-- .grid -->


</section>

