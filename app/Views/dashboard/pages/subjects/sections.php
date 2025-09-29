<?php if (!empty($sections)): ?>
    <table class="table table-zebra-soft mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Slug</th>
                <th>Pages</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sections as $section): ?>
                <tr>
                    <td class="text-info"><?= esc($section['id']) ?></td>
                    <td class="font-semibold"><?= esc($section['title']) ?></td>
                    <td class="text-base-content/70"><?= strip_tags($section['description']) ?></td>
                    <td>
                        <span class="badge badge-dash badge-accent">
                            <?= esc($section['slug']) ?>
                        </span>
                    </td>
                    <td><?= esc($section['count']) ?></td>
                    <td class="text-right">
                        <button class="btn btn-sm" type="button"
                            data-modify-id="<?= esc($section['id']) ?>"
                            data-target-modal="modalSections">
                            Modify
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No sections found.</p>
<?php endif; ?>