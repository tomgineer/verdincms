<?= $this->include('dashboard/pages/trash/header') ?>

<section class="grid grid-col-1 gap-05 mt-2">

    <panel class="tabpanel">

        <header class="flex flex-space gap-2 flex-vt">
            <div>
                <h3 class="tabpanel__title">Members</h3>
                <p class="tabpanel__desc">Members that have been deleted</p>
            </div>
            <button class="btn-outline fs-200" data-dash-action="removeDeletedMembers" data-dash-return="trash/accounts">
                <svg class="svg-icon" aria-hidden="true">
                    <use href="#warning"></use>
                </svg>
                Purge Deleted Members
            </button>
        </header>

        <?php if (!empty($accounts['members'])): ?>
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Last Name</th>
                        <th>First Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Activated</th>
                        <th>Expires</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($accounts['members'] as $member): ?>
                        <tr>
                            <td class="primary"><?= esc($member['id']) ?></td>
                            <td class="primary"><?= esc($member['last_name']) ?></td>
                            <td class="primary"><?= esc($member['first_name']) ?></td>
                            <td><?= esc($member['email']) ?></td>
                            <td class="primary"><?= esc($member['status_label']) ?></td>
                            <td class="primary"><?= esc($member['f_created']) ?></td>
                            <td class="primary"><?= esc($member['f_membership_activated']) ?></td>
                            <td class="primary"><?= esc($member['f_membership_expiration']) ?></td>
                            <td class="primary"><a href="<?= site_url('users/edit_member/' . $member['id']) ?>">Modify</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No deleted members found.</p>
        <?php endif; ?>

    </panel>

    <panel class="panel panel--light">

        <header class="flex flex-space gap-2 flex-vt">
            <div>
                <h3 class="panel__title">Users</h3>
                <p class="panel__desc">Users that have been removed.</p>
            </div>
            <button class="btn-outline fs-200" data-dash-action="removeDeletedUsers" data-dash-return="trash/accounts">
                <svg class="svg-icon" aria-hidden="true">
                    <use href="#warning"></use>
                </svg>
                Purge Deleted Users
            </button>
        </header>

        <?php if (!empty($accounts['users'])): ?>
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
                    <?php foreach ($accounts['users'] as $user): ?>
                        <tr>
                            <td class="primary"><?= esc($user['id']) ?></td>
                            <td class="primary"><?= esc($user['last_name']) ?></td>
                            <td class="primary"><?= esc($user['first_name']) ?></td>
                            <td><?= esc($user['email']) ?></td>
                            <td class="primary"><?= esc($user['group_title']) ?></td>
                            <td class="primary"><?= esc($user['phone']) ?></td>
                            <td class="primary"><?= esc($user['author']) ?></td>
                            <td class="primary"><?= esc($user['status_label']) ?></td>
                            <td class="primary"><?= esc($user['f_created']) ?></td>
                            <td class="primary"><a href="<?= site_url('users/edit/' . $user['id']) ?>">Modify</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No deleted users found.</p>
        <?php endif; ?>

    </panel>

</section>