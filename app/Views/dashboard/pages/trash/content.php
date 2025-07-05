<?= $this->include('dashboard/pages/trash/header') ?>

<section class="grid grid-col-1 gap-05 mt-2">

    <panel class="tabpanel">

        <header class="flex flex-space gap-2 flex-vt">
            <div>
                <h3 class="tabpanel__title">Posts</h3>
                <p class="tabpanel__desc">Posts removed from the site.</p>
            </div>
            <button class="btn-outline fs-200" data-dash-action="removeDeletedPosts" data-dash-return="trash/content">
                <svg class="svg-icon" aria-hidden="true">
                    <use href="#warning"></use>
                </svg>
                Purge Deleted Posts
            </button>
        </header>

        <?php if (!empty($content['posts'])): ?>
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
                    <?php foreach ($content['posts'] as $post): ?>
                        <tr>
                            <td class="primary"><?= esc($post['id']) ?></td>
                            <td class="primary"><?= esc($post['f_status']) ?></td>
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
            <p>No deleted posts found.</p>
        <?php endif; ?>

    </panel>

    <panel class="panel panel--light">

        <header class="flex flex-space gap-2 flex-vt">
            <div>
                <h3 class="panel__title">Pages</h3>
                <p class="panel__desc">Static pages that have been removed from the website.</p>
            </div>
            <button class="btn-outline fs-200" data-dash-action="removeDeletedPages" data-dash-return="trash/content">
                <svg class="svg-icon" aria-hidden="true">
                    <use href="#warning"></use>
                </svg>
                Purge Deleted Pages
            </button>
        </header>

        <?php if (!empty($content['pages'])): ?>
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Title</th>
                        <th>Subtitle</th>
                        <th>Section</th>
                        <th>Slug</th>
                        <th>Hits</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($content['pages'] as $page): ?>
                        <tr>
                            <td class="primary"><?= esc($page['id']) ?></td>
                            <td class="primary"><?= esc($page['f_status']) ?></td>
                            <td class="primary"><?= esc($page['f_created']) ?></td>
                            <td><?= esc($page['title']) ?></td>
                            <td><?= esc($page['subtitle']) ?></td>
                            <td class="primary"><?= esc($page['section']) ?></td>
                            <td class="primary"><?= esc($page['slug']) ?></td>
                            <td class="primary"><?= esc($page['hits']) ?></td>
                            <td class="primary"><a href="<?=site_url('admin/edit/page/'.$page['id'])?>" target="_blank">Modify</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else:?>
            <p>No deleted pages found.</p>
        <?php endif; ?>

    </panel>


</section>