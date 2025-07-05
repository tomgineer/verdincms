<?= $this->include('dashboard/pages/latest/header') ?>

<section class="grid grid-col-1 gap-05 mt-2">

    <panel class="tabpanel">
        <h3 class="tabpanel__title">Posts</h3>
        <p class="tabpanel__desc">Your latest published articles and blog entries.</p>

        <?php if (!empty($posts)): ?>
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Subtitle</th>
                        <th>Hits</th>
                        <th>Words</th>
                        <th>Created</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($posts as $post): ?>
                        <tr>
                            <td><?= esc($post['title']) ?></td>
                            <td><?= esc($post['subtitle']) ?></td>
                            <td class="primary"><?= esc($post['hits']) ?></td>
                            <td class="primary"><?= esc($post['words']) ?></td>
                            <td class="primary"><?= esc($post['f_created']) ?></td>
                            <td class="primary"><a href="<?=site_url('post/'.$post['id'])?>" target="_blank">View</a></td>
                            <td class="primary"><a href="<?=site_url('admin/edit/post/'.$post['id'])?>" target="_blank">Modify</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        <?php else:?>
            <p>No recent posts found.</p>
        <?php endif; ?>

    </panel>

</section>



