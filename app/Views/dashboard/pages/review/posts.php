<?= $this->include('dashboard/pages/review/header') ?>

<section class="grid grid-col-1 gap-05 mt-2">

    <panel class="tabpanel">
        <h3 class="tabpanel__title">Posts</h3>
        <p class="tabpanel__desc">Drafts, unpublished, or published blog posts pending editorial review.</p>

        <?php if (!empty($posts)): ?>
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Created</th>
                        <th>Title</th>
                        <th>Subtitle</th>
                        <th>Topic</th>
                        <th>Hits</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($posts as $post): ?>
                        <tr>
                            <td class="primary"><?= esc($post['id']) ?></td>
                            <td class="primary"><?= esc($post['f_created']) ?></td>
                            <td><?= esc($post['title']) ?></td>
                            <td><?= esc($post['subtitle']) ?></td>
                            <td class="primary"><?= esc($post['topic']) ?></td>
                            <td class="primary"><?= esc($post['hits']) ?></td>
                            <td class="primary"><a href="<?=site_url('admin/edit/post/'.$post['id'])?>" target="_blank">Modify</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No posts pending editorial review found.</p>
        <?php endif; ?>

    </panel>

</section>