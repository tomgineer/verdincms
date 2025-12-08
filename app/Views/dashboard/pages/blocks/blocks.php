<header class="mt-10 mb-4">
    <h1 class="text-5xl mb-2">Blocks</h1>
    <p class="text-base-content/70">Modular content blocks that can be placed across different areas of the website.</p>
</header>

<nav class="flex gap-2 justify-end mb-4">
    <button class="btn btn-sm btn-outline btn-error hidden" type="button" data-bulk-delete="blocks">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
        </svg>
        Delete Selected
    </button>
    <button class="btn btn-sm btn-outline btn-accent" type="button" data-modify-id="new" data-target-modal="modalBlocks">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        New Block
    </button>
</nav>

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
                            <th>&nbsp;</th>
                            <th>Alias</th>
                            <th>Title</th>
                            <th>Group</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $block): ?>
                            <tr>
                                <td class="w-1"><input type="checkbox" class="checkbox" data-delete-id="<?= esc($block['id']) ?>" data-table="blocks" /></td>
                                <td><?= esc($block['alias']) ?></td>
                                <td><?= esc($block['title']) ?></td>
                                <td>
                                    <span class="badge badge-dash badge-accent"><?= esc($group) ?></span>
                                </td>
                                <td class="text-right">
                                    <button class="btn btn-sm" type="button"
                                            data-modify-id="<?= esc($block['id']) ?>"
                                            data-target-modal="modalBlocks">
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