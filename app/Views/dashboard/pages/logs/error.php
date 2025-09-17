<nav class="flex justify-end mb-4">
    <button class="btn btn-sm btn-outline btn-error" data-dash-action="clearErrorLogFiles" data-dash-return="logs/logs">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
        </svg>
        Purge System Errors
    </button>
</nav>

<?php if (!empty($errors)): ?>
    <table class="table table-zebra-soft">
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
                    <td class="min-w-40 text-error"><?= esc($log['filename']) ?></td>
                    <th class="min-w-45">
                        <?= $log['date'] > 0
                            ? date('Y-m-d H:i:s', $log['date'])
                            : '<em>Unavailable</em>' ?>
                    </th>
                    <td class="align-top text-base-content/85">
                        <div class="max-h-40 overflow-y-auto">
                            <pre class="m-0 whitespace-pre-wrap break-words text-sm leading-tight"><?= esc($log['content']) ?></pre>
                        </div>
                    </td>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No logs found in the directory.</p>
<?php endif; ?>