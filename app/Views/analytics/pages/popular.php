<header class="dash-page-header">
    <div>
        <h1 class="ff-body fw-500 ls-1 mb-0">Popular Content</h1>
        <p class="color-300 mb-0 lh-150">Explore the most visited content on your website and what your audience engages with most.</p>
    </div>
</header>

<section class="grid grid-col-1 gap-05 grid-break-md mt-2">

    <panel class="tabpanel">
        <h3 class="tabpanel__title">Posts</h3>
        <p class="tabpanel__desc">Highest-performing posts of all time.</p>

        <?php if (!empty($posts)): ?>
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Title</th>
                        <th>Subtitle</th>
                        <th>Hits</th>
                        <th>Words</th>
                        <th>Created</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($posts as $index => $post): ?>
                        <tr>
                            <td class="primary"><?= ($index + 1) ?></td>
                            <td><?= esc($post['title']) ?></td>
                            <td><?= esc($post['subtitle']) ?></td>
                            <td class="primary"><?= esc($post['hits']) ?></td>
                            <td class="primary"><?= esc($post['words']) ?></td>
                            <td class="primary"><?= esc($post['f_created']) ?></td>
                            <td class="primary"><a href="<?=site_url('post/'.$post['id'])?>" target="_blank">View</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        <?php else:?>
            <p>No popular posts found.</p>
        <?php endif; ?>

    </panel>

    <panel class="panel panel--light">
        <h3 class="panel__title">Pages</h3>
        <p class="panel__desc">Most viewed pages across the site.</p>

        <?php if (!empty($pages)): ?>
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Title</th>
                        <th>Subtitle</th>
                        <th>Slug</th>
                        <th>Section</th>
                        <th>Hits</th>
                        <th>Words</th>
                        <th>Created</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pages as $index => $page): ?>
                        <tr>
                            <td class="primary"><?= ($index + 1) ?></td>
                            <td><?= esc($page['title']) ?></td>
                            <td><?= esc($page['subtitle']) ?></td>
                            <td class="primary"><?= esc($page['slug']) ?></td>
                            <td class="primary"><?= esc($page['s_slug']) ?></td>
                            <td class="primary"><?= esc($page['hits']) ?></td>
                            <td class="primary"><?= esc($page['words']) ?></td>
                            <td class="primary"><?= esc($page['f_created']) ?></td>
                            <td class="primary"><a href="<?=site_url($page['s_slug'].'/'.$page['slug'])?>" target="_blank">View</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        <?php else:?>
            <p>No popular pages found.</p>
        <?php endif; ?>

    </panel>

</section>
