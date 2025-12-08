<header class="mt-10 mb-4">
    <h1 class="text-5xl mb-2">Accounts</h1>
    <p class="text-base-content/70">Manage internal system users and public website members.</p>
</header>

<section class="tabs tabs-lg tabs-border">
    <input type="radio" name="accounts" class="tab" aria-label="Users" checked="checked" />
    <div class="tab-content border-0 p-8">
        <p class="mb-2">Admins and staff with access to internal tools and settings.</p>
        <?= $this->include('dashboard/pages/accounts/users') ?>
    </div>
</section>

<?= $this->include('dashboard/pages/accounts/modal_users') ?>