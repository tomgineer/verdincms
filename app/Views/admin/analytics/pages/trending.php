<header class="mt-10 mb-8">
    <h1 class="text-5xl mb-2">Trending Posts</h1>
    <p class="text-base-content/70">Discover which posts are currently receiving the most attention.</p>
</header>

<section class="grid grid-cols-1 gap-16">
    <div class="p-0">
        <h3 class="text-3xl mb-1">Posts</h3>
        <p class="text-base-content/70 mb-4">Showing posts trending over the past hour.</p>

        <?php if (!empty($trending)): ?>
            <table class="table table-zebra-soft">
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Hits last hour</th>
                        <th>Title</th>
                        <th>Subtitle</th>
                        <th>Total Hits</th>
                        <th>Words</th>
                        <th>Created</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($trending as $index => $post): ?>
                        <tr>
                            <td><?= ($index + 1) ?></td>
                            <td><?= esc($post['trending_hits']) ?></td>
                            <td><?= esc($post['title']) ?></td>
                            <td><?= esc($post['subtitle']) ?></td>
                            <td><?= esc($post['hits']) ?></td>
                            <td><?= esc($post['words']) ?></td>
                            <td><?= esc($post['f_created']) ?></td>
                            <td>
                                <a class="btn btn-sm hover:btn-primary" href="<?= site_url('post/'.$post['id']) ?>" target="_blank">
                                    View
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No popular posts found.</p>
        <?php endif; ?>
    </div>
</section>
