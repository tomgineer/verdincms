<header class="mt-10 mb-4">
    <h1 class="text-5xl mb-2">Blocks</h1>
    <p class="text-base-content/70">Modular content blocks that can be placed across different areas of the website.</p>
    <span class="badge badge-dash badge-success block mt-2">Modal Finished!</span>
</header>

<div class="tabs tabs-lg tabs-border">
    <?php $firstGroup = array_key_first($blocks); ?>
    <?php foreach ($blocks as $group => $items): ?>

        <input
            type="radio"
            name="blocks"
            class="tab"
            aria-label="<?= esc(ucwords(str_replace('_', ' ', $group))) ?>"
            <?= $group === $firstGroup ? 'checked="checked"' : '' ?> />

        <div class="tab-content p-8">
            <p class="mb-2">Blocks in group: <strong><?= esc(ucwords($group)) ?></strong></p>
            <?php if (!empty($items)): ?>
                <table class="table table-zebra-soft">
                    <thead>
                        <tr>
                            <th>Alias</th>
                            <th>Title</th>
                            <th>Group</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $block): ?>
                            <tr>
                                <th><?= esc($block['alias']) ?></th>
                                <td><?= esc($block['title']) ?></td>
                                <td>
                                    <span class="badge badge-dash badge-accent"><?= esc($group) ?></span>
                                </td>
                                <td class="text-right">
                                    <button class="btn btn-sm" type="button"
                                            data-modify-id="<?= esc($block['id']) ?>"
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
        </div>

    <?php endforeach; ?>
</div>

<?= $this->include('dashboard/pages/blocks/modal_blocks') ?>