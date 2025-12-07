<nav class="flex gap-2 justify-end mb-4">
    <button class="btn btn-outline btn-sm btn-accent" type="button" data-modify-id="new" data-target-modal="modalTopics">
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
