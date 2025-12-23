<header class="mt-10 mb-4">
    <h1 class="text-5xl mb-2">Blocks</h1>
    <p class="text-base-content/70">Modular content blocks that can be placed across different areas of the website.</p>
</header>

<section class="tabs tabs-lg tabs-border">
    <input type="radio" name="subjects" class="tab" aria-label="Blocks" checked="checked" />
    <div class="tab-content border-0 p-8">
        <p class="mb-2">Create, edit, and organize blocks and their associated content.</p>
        <?= $this->include('admin/dashboard/pages/blocks/blocks_list') ?>
    </div>

    <input type="radio" name="subjects" class="tab" aria-label="Groups" />
    <div class="tab-content border-0 p-8">
        <p class="mb-2">Create and manage block groups to better structure your blocks.</p>
        <?= $this->include('admin/dashboard/pages/blocks/groups') ?>
    </div>
</section>

<?= $this->include('admin/dashboard/pages/blocks/modal_blocks') ?>
<?= $this->include('admin/dashboard/pages/blocks/modal_block_groups') ?>
