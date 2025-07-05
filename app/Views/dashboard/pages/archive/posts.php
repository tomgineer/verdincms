<?= $this->include('dashboard/pages/archive/header') ?>

<section class="grid grid-col-1 gap-05 mt-2">

    <panel class="tabpanel">


        <header class="flex flex-space gap-2 flex-vt">
            <div>
                <h3 class="tabpanel__title">Posts</h3>
                <p class="tabpanel__desc">All draft of deleted posts.</p>
            </div>
            <button class="btn-outline fs-200" data-dash-action="removeDeletedPosts" data-dash-return="archive/posts">
                <svg class="svg-icon" aria-hidden="true">
                    <use href="#warning"></use>
                </svg>
                Purge Deleted Posts
            </button>
        </header>

        <?php if (!empty($posts)): ?>
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Status</th>
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
                            <td class="primary">
                                <?= esc($post['f_status']) ?>
                            </td>
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

        <?php else:?>
            <p>No draft of deleted posts found.</p>
        <?php endif; ?>


    </panel>

</section>