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

<?= $this->include('dashboard/pages/subjects/modal_topics') ?>