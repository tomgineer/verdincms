<nav class="flex gap-2 justify-end mb-4">
    <button class="btn btn-sm btn-outline btn-error hidden" type="button" data-bulk-delete="newsletter">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
        </svg>
        Delete Selected
    </button>
</nav>

<div class="mt-8">
    <h3 class="text-2xl">Active Subscribers</h3>
    <?php if (!empty($subscribers['active_subs'])): ?>
        <table class="table table-zebra-soft mt-4">
            <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Subscribed At</th>
                    <th>Confirmed</th>
                    <th>Confirmed At</th>
                    <th>Confirmation Token</th>
                    <th>Unsubscribed</th>
                    <th>Unsubscribed At</th>
                    <th>Unsubscribe Token</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($subscribers['active_subs'] as $subscriber): ?>
                    <tr>
                        <td class="w-1"><input type="checkbox" class="checkbox" data-delete-id="<?= esc($subscriber['id']) ?>" data-table="newsletter" /></td>
                        <td class="text-info"><?= esc($subscriber['id']) ?></td>
                        <td class="font-semibold"><?= esc($subscriber['email']) ?></td>
                        <td><?= esc($subscriber['subscribed_at']) ?></td>
                        <td>
                            <span class="badge badge-sm badge-dash <?= (!empty($subscriber['confirmed']) ? 'badge-success' : 'badge-error') ?>">
                                <?= esc(!empty($subscriber['confirmed']) ? 'Yes' : 'No') ?>
                            </span>
                        </td>
                        <td><?= esc($subscriber['confirmed_at']) ?></td>
                        <td class="text-xs"><?= esc($subscriber['confirmation_token']) ?></td>
                        <td>
                            <span class="badge badge-sm badge-dash <?= (!empty($subscriber['unsubscribed']) ? 'badge-success' : 'badge-error') ?>">
                                <?= esc(!empty($subscriber['unsubscribed']) ? 'Yes' : 'No') ?>
                            </span>
                        </td>
                        <td><?= esc($subscriber['unsubscribed_at']) ?></td>
                        <td class="text-xs"><?= esc($subscriber['unsubscribe_token']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-base-content/70 text-sm">No active subscribers found.</p>
    <?php endif; ?>

</div>

<div class="mt-12">
    <h3 class="text-2xl">Inactive Subscribers</h3>
    <?php if (!empty($subscribers['inactive_subs'])): ?>
        <table class="table table-zebra-soft mt-4">
            <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Subscribed At</th>
                    <th>Confirmed</th>
                    <th>Confirmed At</th>
                    <th>Confirmation Token</th>
                    <th>Unsubscribed</th>
                    <th>Unsubscribed At</th>
                    <th>Unsubscribe Token</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($subscribers['inactive_subs'] as $subscriber): ?>
                    <tr>
                        <td class="w-1"><input type="checkbox" class="checkbox" data-delete-id="<?= esc($subscriber['id']) ?>" data-table="newsletter" /></td>
                        <td class="text-info"><?= esc($subscriber['id']) ?></td>
                        <td class="font-semibold"><?= esc($subscriber['email']) ?></td>
                        <td><?= esc($subscriber['subscribed_at']) ?></td>
                        <td>
                            <span class="badge badge-sm badge-dash <?= (!empty($subscriber['confirmed']) ? 'badge-success' : 'badge-error') ?>">
                                <?= esc(!empty($subscriber['confirmed']) ? 'Yes' : 'No') ?>
                            </span>
                        </td>
                        <td><?= esc($subscriber['confirmed_at']) ?></td>
                        <td class="text-xs"><?= esc($subscriber['confirmation_token']) ?></td>
                        <td>
                            <span class="badge badge-sm badge-dash <?= (!empty($subscriber['unsubscribed']) ? 'badge-success' : 'badge-error') ?>">
                                <?= esc(!empty($subscriber['unsubscribed']) ? 'Yes' : 'No') ?>
                            </span>
                        </td>
                        <td><?= esc($subscriber['unsubscribed_at']) ?></td>
                        <td class="text-xs"><?= esc($subscriber['unsubscribe_token']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-base-content/70 text-sm">No inactive subscribers found.</p>
    <?php endif; ?>

</div>