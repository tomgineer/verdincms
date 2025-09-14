<?php if (!empty($hits)): ?>
    <table class="table table-zebra-soft">
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
                    <td class="text-info"><?= esc($item['hits']) ?></td>
                    <td><?= esc($item['date_logged']) ?></td>
                    <td><?= esc($item['ip']) ?></td>
                    <td class="text-xs text-base-content/70"><?= esc($item['fingerprint']) ?></td>
                    <td><?= esc($item['os']) ?></td>
                    <td><?= esc($item['browser']) ?></td>
                    <td class="text-base-content/70"><?= esc($item['browser_ver']) ?></td>
                    <th><?= esc($item['country']) ?></th>
                    <td>
                        <span class="badge badge-dash <?= ($item['is_mobile'] === 'Yes' ? 'badge-success' : 'badge-warning') ?>">
                            <?= esc($item['is_mobile']) ?>
                        </span>
                    </td>
                    <td class="min-w-40"><?= esc($item['updated']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No visitor activity found.</p>
<?php endif; ?>