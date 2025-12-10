<div class="overflow-x-auto">
    <table class="table table-zebra table-sm w-full">
        <tbody>
            <tr>
                <th>ID</th>
                <td><?= esc($post['id']) ?></td>
            </tr>

            <tr>
                <th>Type</th>
                <td><?= esc(ucfirst($type)) ?></td>
            </tr>

            <tr>
                <th>Status</th>
                <td data-info="status">
                    <?php $statusText = $statusLabels[$post['status']] ?? 'Unknown'; ?>
                    <?php $statusTone = $statusColors[$post['status']] ?? 'neutral'; // e.g. success|warning|error|info|neutral ?>
                    <span class="badge badge-dash badge-sm font-semibold badge-<?= esc($statusTone) ?>"><?= esc($statusText) ?></span>
                </td>
            </tr>

            <?php if ($type === 'page'): ?>
                <tr>
                    <th>Position</th>
                    <td>0</td>
                </tr>
            <?php endif; ?>

            <tr>
                <th>Words</th>
                <td>
                    <span class="badge badge-dash badge-sm font-semibold" data-info="words"><?= esc($post['words']) ?></span>
                </td>
            </tr>

            <tr>
                <th>Hits</th>
                <td><?= esc($post['hits']) ?></td>
            </tr>

            <tr>
                <th>Characters</th>
                <td data-info="chars">0</td>
            </tr>

            <tr>
                <th>Syntax Highlighting</th>
                <td><?= esc($post['highlight'] == 1 ? 'Yes' : 'No') ?></td>
            </tr>

            <tr>
                <th>Created</th>
                <td data-info="created"><?= esc(date('F j, Y', strtotime($post['created']))) ?></td>
            </tr>
        </tbody>
    </table>
</div>

