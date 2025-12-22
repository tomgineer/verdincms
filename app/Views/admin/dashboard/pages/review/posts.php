<?php if (!empty($posts)): ?>
    <table class="table table-zebra-soft">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Subtitle</th>
                <th>Created</th>
                <th>Topic</th>
                <th>Hits</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($posts as $post): ?>
                <tr>
                    <td class="text-info"><?= esc($post['id']) ?></td>
                    <td><?= esc($post['title']) ?></td>
                    <td class="text-xs text-base-content/70"><?= esc($post['subtitle']) ?></td>
                    <td class="min-w-40"><?= esc($post['f_created']) ?></td>
                    <td>
                        <span class="badge badge-dash badge-accent"><?= esc($post['topic']) ?></span>
                    </td>
                    <td><?= esc($post['hits']) ?></td>
                    <td>
                        <a class="btn btn-sm" href="<?=site_url('admin/edit/post/'.$post['id'])?>" target="_blank">
                            Modify
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No posts pending editorial review found.</p>
<?php endif; ?>
