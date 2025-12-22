<?php if (!empty($pages)): ?>
    <table class="table table-zebra-soft">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Subtitle</th>
                <th>Created</th>
                <th>Section</th>
                <th>Slug</th>
                <th>Hits</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pages as $page): ?>
                <tr>
                    <td class="text-info"><?= esc($page['id']) ?></td>
                    <td><?= esc($page['title']) ?></td>
                    <td class="text-xs text-base-content/70"><?= esc($page['subtitle']) ?></td>
                    <td class="min-w-40"><?= esc($page['f_created']) ?></td>
                    <td>
                        <span class="badge badge-dash badge-accent"><?= esc($page['section']) ?></span>
                    </td>
                    <td class="text-base-content/70"><?= esc($page['slug']) ?></td>
                    <td><?= esc($page['hits']) ?></td>
                    <td>
                        <a class="btn btn-sm" href="<?=site_url('admin/edit/page/'.$page['id'])?>" target="_blank">
                            Modify
                        </a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No content pages requiring updates found.</p>
<?php endif; ?>

