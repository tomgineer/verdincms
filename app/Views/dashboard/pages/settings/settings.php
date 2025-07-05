<header class="dash-page-header">
    <div>
        <h1 class="ff-body fw-500 ls-1 mb-0">Settings</h1>
        <p class="color-300 mb-0 lh-150">Manage and customize system preferences.</p>
    </div>
</header>

<section class="grid grid-col-2 gap-05 grid-break-md mt-2">

    <?php $index = 0;?>
    <?php foreach ($settings as $group => $items): ?>

        <?php
            $panelClass = match ($index) {
            0 => 'tabpanel',
            1 => 'tabpanel tabpanel--right tabpanel--light',
            2 => 'panel panel--light',
            3 => 'panel',
            4 => 'panel',
            default => 'panel'
        };?>

        <panel class="<?= esc($panelClass) ?>">
            <header class="flex flex-space gap-2 flex-vt">
                <div>
                    <h3 class="tabpanel__title"><?= esc(ucwords(str_replace('_', ' ', $group))) ?></h3>
                    <p class="tabpanel__desc">Settings related to <?= esc($group) ?>.</p>
                </div>
            </header>

            <?php if (!empty($items)): ?>
                <table class="dash-table">
                    <thead>
                        <tr>
                            <th>Key</th>
                            <th>Value</th>
                            <th>Title</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $setting): ?>
                            <tr>
                                <td class="primary"><?= esc($setting['setting']) ?></td>
                                <td><?= esc($setting['value']) ?></td>
                                <td><?= esc($setting['title']) ?></td>
                                <td class="primary">
                                    <button type="button"
                                        data-modify-button="<?= esc($setting['id']) ?>"
                                        data-target-modal="modalSettings">
                                        Modify
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No settings available in this group.</p>
            <?php endif; ?>
        </panel>

        <?php $index++; ?>
    <?php endforeach; ?>

</section>

<?= $this->include('dashboard/pages/settings/modal_settings') ?>
