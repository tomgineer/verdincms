<header class="mt-10 mb-8">
    <h1 class="text-5xl mb-2">Popular Content</h1>
    <p class="text-base-content/70">Explore the most visited content on your website and what your audience engages with most.</p>
</header>

<section class="grid grid-cols-1 gap-16">
    <div class="p-0">
        <h3 class="text-3xl mb-1">Posts</h3>
        <p class="text-base-content/70 mb-4">Highest-performing posts of all time.</p>

        <?php if (!empty($posts)): ?>
            <table class="table table-zebra-soft">
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
                            <td><?= ($index + 1) ?></td>
                            <td><?= esc($post['title']) ?></td>
                            <td><?= esc($post['subtitle']) ?></td>
                            <td><?= esc($post['hits']) ?></td>
                            <td><?= esc($post['words']) ?></td>
                            <td><?= esc($post['f_created']) ?></td>
                            <td><a class="btn btn-sm hover:btn-primary" href="<?= site_url('post/'.$post['id']) ?>" target="_blank">View</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No popular posts found.</p>
        <?php endif; ?>
    </div>

    <div class="p-0">
        <h3 class="text-3xl mb-1">Pages</h3>
        <p class="text-base-content/70 mb-4">Most viewed pages across the site.</p>

        <?php if (!empty($pages)): ?>
            <table class="table table-zebra-soft">
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
                            <td><?= ($index + 1) ?></td>
                            <td><?= esc($page['title']) ?></td>
                            <td><?= esc($page['subtitle']) ?></td>
                            <td><?= esc($page['slug']) ?></td>
                            <td><?= esc($page['s_slug']) ?></td>
                            <td><?= esc($page['hits']) ?></td>
                            <td><?= esc($page['words']) ?></td>
                            <td><?= esc($page['f_created']) ?></td>
                            <td><a class="btn btn-sm hover:btn-primary" href="<?= site_url($page['s_slug'].'/'.$page['slug']) ?>" target="_blank">View</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No popular pages found.</p>
        <?php endif; ?>
    </div>
</section>
