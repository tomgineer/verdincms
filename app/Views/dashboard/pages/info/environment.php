<?= $this->include('dashboard/pages/info/header') ?>

<section class="grid grid-col-2 gap-05 grid-break-md mt-2">

    <panel class="tabpanel">
        <h3 class="tabpanel__title">PHP Info</h3>
        <p class="tabpanel__desc">Details about the PHP environment, version, configuration, and loaded extensions.</p>

        <?php if (!empty($php_info)): ?>
            <table class="dash-table dash-table--primary">
                <thead>
                    <tr>
                        <th>Property</th>
                        <th>Value</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($php_info as $label => $value): ?>
                        <tr>
                            <td class="primary"><?=$label?></td>
                            <td><?=$value?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

    </panel>

    <panel class="tabpanel tabpanel--right tabpanel--light">
        <h3 class="tabpanel__title">GD Info</h3>
        <p class="tabpanel__desc">Information about the GD library version and supported image types.</p>

        <?php if (!empty($gd_info)): ?>
            <table class="dash-table dash-table--primary">
                <thead>
                    <tr>
                        <th>Property</th>
                        <th>Value</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($gd_info as $label => $value): ?>
                        <tr>
                            <td class="primary"><?=$label?></td>
                            <td><?=$value?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

    </panel>

</section>