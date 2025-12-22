<nav class="flex gap-2 justify-end mb-4">
    <button class="btn btn-sm btn-outline btn-error hidden" type="button" data-bulk-delete="users">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
        </svg>
        Delete Selected
    </button>
    <button class="btn btn-sm btn-outline btn-accent" type="button" data-modify-id="new" data-target-modal="modalUsers">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        New User
    </button>
</nav>

<?php if (!empty($users)): ?>
    <table class="table table-zebra-soft">
        <thead>
            <tr>
                <th>&nbsp;</th>
                <th>ID</th>
                <th>Last Name</th>
                <th>First Name</th>
                <th>Email</th>
                <th>Group</th>
                <th>Phone</th>
                <th>Handle</th>
                <th>Status</th>
                <th>Created</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td class="w-1"><input type="checkbox" class="checkbox" data-delete-id="<?= esc($user['id']) ?>" data-table="users" /></td>
                    <td class="text-info"><?= esc($user['id']) ?></td>
                    <td class="font-bold"><?= esc($user['last_name']) ?></td>
                    <td><?= esc($user['first_name']) ?></td>
                    <td><?= esc($user['email']) ?></td>
                    <td><?= esc($user['group_title']) ?></td>
                    <td class="text-xs text-base-content/70"><?= esc($user['phone']) ?></td>
                    <td class="text-xs text-base-content/70"><?= esc($user['author']) ?></td>
                    <td>
                        <span class="badge badge-dash <?= ($user['status_label'] === 'Active' ? 'badge-success' : 'badge-warning') ?>">
                            <?= esc($user['status_label']) ?>
                        </span>
                    </td>
                    <td><?= esc($user['f_created']) ?></td>
                    <td class="text-right">
                        <button class="btn btn-sm" type="button"
                            data-modify-id="<?= esc($user['id']) ?>"
                            data-target-modal="modalUsers">
                            Modify
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No users found.</p>
<?php endif; ?>

