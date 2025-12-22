<?php if (!empty($pages)): ?>
    <table class="table table-zebra-soft">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Subtitle</th>
                <th>Slug</th>
                <th>Section</th>
                <th>Hits</th>
                <th>Words</th>
                <th>Created</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pages as $page): ?>
                <tr>
                    <td class="text-info"><?= esc($page['id']) ?></td>
                    <td><?= esc($page['title']) ?></td>
                    <td class="text-xs text-base-content/70"><?= esc($page['subtitle']) ?></td>
                    <td class="text-xs text-base-content/70"><?= esc($page['slug']) ?></td>
                    <td>
                        <span class="badge badge-dash badge-accent"><?= esc($page['s_slug']) ?></span>
                    </td>
                    <td><?= esc($page['hits']) ?></td>
                    <td><?= esc($page['words']) ?></td>
                    <td class="min-w-40"><?= esc($page['f_created']) ?></td>
                    <td>
                        <a class="btn btn-sm btn-soft btn-warning" href="<?=site_url($page['s_slug'] . '/'. $page['slug'])?>" target="_blank">
                            View
                        </a>
                    </td>
                    <td>
                        <a class="btn btn-sm" href="<?=site_url('admin/edit/page/'.$page['id'])?>" target="_blank">
                            Modify
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<?php else:?>
    <p>No recent pages found.</p>
<?php endif; ?>

