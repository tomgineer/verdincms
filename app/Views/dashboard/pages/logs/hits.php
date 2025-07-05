<?= $this->include('dashboard/pages/logs/header') ?>

<section class="grid grid-col-1 gap-05 mt-2">

    <panel class="tabpanel tabpanel--right tabpanel--light">
        <h3 class="tabpanel__title">Raw Hits</h3>
        <p class="tabpanel__desc">Unprocessed visit logs and request activity.</p>

        <?php if (!empty($hits)): ?>
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>Hits</th>
                        <th>Logged</th>
                        <th>IP</th>
                        <th>Fingerprint</th>
                        <th>OS</th>
                        <th>Browser</th>
                        <th>Version</th>
                        <th>Country</th>
                        <th>Mobile</th>
                        <th>Updated</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($hits as $item): ?>
                        <tr>
                            <td class="primary"><?= esc($item['hits']) ?></td>
                            <td class="primary"><?= esc($item['date_logged']) ?></td>
                            <td class="primary"><?= esc($item['ip']) ?></td>
                            <td><?= esc($item['fingerprint']) ?></td>
                            <td class="primary"><?= esc($item['os']) ?></td>
                            <td class="primary"><?= esc($item['browser']) ?></td>
                            <td class="primary"><?= esc($item['browser_ver']) ?></td>
                            <td class="primary"><?= esc($item['country']) ?></td>
                            <td class="primary"><?= esc($item['is_mobile']) ?></td>
                            <td class="primary"><?= esc($item['updated']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No visitor activity found.</p>
        <?php endif; ?>

    </panel>

</section>
