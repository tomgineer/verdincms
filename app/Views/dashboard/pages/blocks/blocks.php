<header class="dash-page-header">
    <div>
        <h1 class="ff-body fw-500 ls-1 mb-0">Blocks</h1>
        <p class="color-300 mb-0 lh-150">Modular content blocks that can be placed across different areas of the website.</p>
    </div>
</header>

<section class="grid grid-col-2 gap-05 grid-break-md mt-2">
    <?php $index = 0; ?>
    <?php foreach ($blocks as $group => $items): ?>

        <?php
        $panelClass = match ($index) {
            0 => 'tabpanel',
            1 => 'tabpanel tabpanel--right tabpanel--light',
            2 => 'panel panel--light',
            3 => 'panel',
            4 => 'panel',
            default => 'panel'
        };
        ?>

        <panel class="<?= esc($panelClass) ?>">
            <header class="flex flex-space gap-2 flex-vt">
                <div>
                    <h3 class="tabpanel__title"><?= esc(ucwords(str_replace('_', ' ', $group))) ?></h3>
                    <p class="tabpanel__desc">Blocks in group: <?= esc($group) ?></p>
                </div>
            </header>

            <?php if (!empty($items)): ?>
                <table class="dash-table">
                    <thead>
                        <tr>
                            <th>Alias</th>
                            <th>Title</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $block): ?>
                            <tr>
                                <td class="primary"><?= esc($block['alias']) ?></td>
                                <td><?= esc($block['title']) ?></td>
                                <td class="primary">
                                    <button type="button"
                                            data-modify-button="<?= esc($block['id']) ?>"
                                            data-target-modal="modalBlock">
                                        Modify
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No blocks in this group.</p>
            <?php endif; ?>
        </panel>

        <?php $index++; ?>
    <?php endforeach; ?>
</section>

<?= $this->include('dashboard/pages/blocks/modal_blocks') ?>