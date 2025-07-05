<?= $this->include('dashboard/pages/logs/header') ?>

<section class="grid grid-col-1 gap-05 mt-2">

    <panel class="tabpanel tabpanel--alert">

        <header class="flex flex-space gap-2 flex-vt">
            <div>
                <h3 class="tabpanel__title">System Errors</h3>
                <p class="tabpanel__desc">Captured exceptions and error trace logs.</p>
            </div>
            <button class="btn-outline fs-200" data-dash-action="clearErrorLogFiles" data-dash-return="logs/error">
                <svg class="svg-icon" aria-hidden="true">
                    <use href="#mop"></use>
                </svg>
                Purge System Errors
            </button>
        </header>

        <?php if (!empty($errors)): ?>
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>Filename</th>
                        <th>Last Modified</th>
                        <th>Log Content</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($errors as $log): ?>
                        <tr>
                            <td class="primary"><?= esc($log['filename']) ?></td>
                            <td class="primary">
                                <?= $log['date'] > 0
                                    ? date('Y-m-d H:i:s', $log['date'])
                                    : '<em>Unavailable</em>' ?>
                            </td>
                            <td>
                                <pre><?= esc($log['content']) ?></pre>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No logs found in the directory.</p>
        <?php endif; ?>

    </panel>

</section>
