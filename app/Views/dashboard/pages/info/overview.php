<?= $this->include('dashboard/pages/info/header') ?>

<section class="grid grid-col-2 gap-05 grid-break-md mt-2">

    <panel class="tabpanel">
        <h3 class="tabpanel__title">Overview</h3>
        <p class="tabpanel__desc">Overview of the app and server environment, including framework versions and key PHP settings — useful for debugging and maintenance.</p>

        <?php if (!empty($info['system'])): ?>
            <table class="dash-table dash-table--primary">
                <thead>
                    <tr>
                        <th>Property</th>
                        <th>Value</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($info['system'] as $label => $value): ?>
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
        <h3 class="tabpanel__title">Database Info</h3>
        <p class="tabpanel__desc">Key database connection details, including version, charset, time settings, and session-specific information.</p>

        <?php if (!empty($info['database'])): ?>
            <table class="dash-table dash-table--primary">
                <thead>
                    <tr>
                        <th>Property</th>
                        <th>Value</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($info['database'] as $label => $value): ?>
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



