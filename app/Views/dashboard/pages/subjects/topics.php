<nav class="flex gap-2 justify-end mb-4">
    <button class="btn btn-sm btn-outline btn-error hidden" type="button" data-bulk-delete="topics">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
        </svg>
        Delete Selected
    </button>
    <button class="btn btn-sm btn-outline btn-accent" type="button" data-modify-id="new" data-target-modal="modalTopics">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        New Topic
    </button>
</nav>

<?php if (!empty($topics)): ?>
    <table class="table table-zebra-soft mt-4">
        <thead>
            <tr>
                <th>&nbsp;</th>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Slug</th>
                <th>Posts</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($topics as $topic): ?>
                <tr>
                    <td>
                        <input type="checkbox" class="checkbox" data-delete-id="<?= esc($topic['id']) ?>" data-table="topics" />
                    </td>
                    <td class="text-info"><?= esc($topic['id']) ?></td>
                    <td class="font-semibold"><?= esc($topic['title']) ?></td>
                    <td class="text-base-content/70"><?= strip_tags($topic['description']) ?></td>
                    <td>
                        <span class="badge badge-dash badge-accent">
                            <?= esc($topic['slug']) ?>
                        </span>
                    </td>
                    <td><?= esc($topic['count']) ?></td>
                    <td class="text-right">
                        <button class="btn btn-sm" type="button"
                            data-modify-id="<?= esc($topic['id']) ?>"
                            data-target-modal="modalTopics">
                            Modify
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No topics found.</p>
<?php endif; ?>