<header class="dash-page-header">
    <div>
        <h1 class="ff-body fw-500 ls-1 mb-0">Trending Posts</h1>
        <p class="color-300 mb-0 lh-150">Discover which posts are currently receiving the most attention.</p>
    </div>
</header>

<section class="grid grid-col-1 gap-05 mt-2">

    <panel class="tabpanel">
        <h3 class="tabpanel__title">Posts</h3>
        <p class="tabpanel__desc">Showing posts trending over the past hour.</p>

        <?php if (!empty($trending)): ?>
            <table class="dash-table">
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
                            <td class="primary"><?= ($index + 1) ?></td>
                            <td class="primary"><?= esc($post['trending_hits']) ?></td>
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

</section>
