<?= $this->include('dashboard/pages/accounts/header') ?>

<section class="grid grid-col-1 gap-05 mt-2">

    <panel class="tabpanel">

        <header class="flex gap-05 flex-vt">
            <div class="flex-1">
                <h3 class="tabpanel__title">Users</h3>
                <p class="tabpanel__desc">Admins and staff with access to internal tools and settings.</p>
            </div>

            <button class="btn-outline fs-200" data-dash-action="removeDeletedUsers" data-dash-return="accounts/users">
                <svg class="svg-icon" aria-hidden="true">
                    <use href="#warning"></use>
                </svg>
                Purge Deleted Users
            </button>

            <a class="btn-outline fs-200" href="<?=site_url('users/edit/new')?>" target="_blank">
                <svg class="svg-icon" aria-hidden="true">
                    <use href="#plus"></use>
                </svg>
                New User
            </a>
        </header>

        <?php if (!empty($users)): ?>
            <table class="dash-table">
                <thead>
                    <tr>
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
                            <td class="primary"><?= esc($user['id']) ?></td>
                            <td class="primary"><?= esc($user['last_name']) ?></td>
                            <td class="primary"><?= esc($user['first_name']) ?></td>
                            <td><?= esc($user['email']) ?></td>
                            <td class="primary"><?= esc($user['group_title']) ?></td>
                            <td class="primary"><?= esc($user['phone']) ?></td>
                            <td class="primary"><?= esc($user['author']) ?></td>
                            <td class="primary">
                                <?= esc($user['status_label']) ?>
                            </td>
                            <td class="primary"><?= esc($user['f_created']) ?></td>
                            <td class="primary">
                                <button type="button"
                                    data-modify-button="<?= esc($user['id']) ?>"
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

    </panel>

</section>

<?= $this->include('dashboard/pages/accounts/modal_users') ?>
