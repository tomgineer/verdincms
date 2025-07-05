<header class="dash-page-header">
    <div>
        <h1 class="ff-body fw-500 ls-1 mb-0">Popular Topics & Sections</h1>
        <p class="color-300 mb-0 lh-150">Explore the most viewed topics and sections based on visitor activity.</p>
    </div>
</header>

<section class="grid grid-col-2 gap-05 grid-break-md mt-2">

    <panel class="tabpanel">
        <h3 class="tabpanel__title">Topics</h3>
        <p class="tabpanel__desc">Top topics based on post engagement.</p>

        <?php if (!empty($stats['topics'])): ?>
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Slug</th>
                        <th>Posts</th>
                        <th>Total Hits</th>
                        <th>Hits/Post</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($stats['topics'] as $topic): ?>
                        <tr>
                            <td><?= esc($topic['title']) ?></td>
                            <td class="primary"><?= esc($topic['slug']) ?></td>
                            <td class="primary"><?= esc($topic['posts']) ?></td>
                            <td class="primary"><?= esc($topic['hits']) ?></td>
                            <td class="primary"><?= esc($topic['hits_post']) ?></td>
                            <td class="primary">
                                <a href="<?= site_url('topic/'. $topic['slug']) ?>" target="_blank">View</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No popular topics found.</p>
        <?php endif; ?>


    </panel>

    <panel class="tabpanel tabpanel--right tabpanel--light">
        <h3 class="tabpanel__title">Sections</h3>
        <p class="tabpanel__desc">Most visited sections based on page views.</p>

        <?php if (!empty($stats['sections'])): ?>
            <table class="dash-table mt-2">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Slug</th>
                        <th>Pages</th>
                        <th>Total Hits</th>
                        <th>Hits/Page</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($stats['sections'] as $section): ?>
                        <tr>
                            <td><?= esc($section['title']) ?></td>
                            <td class="primary"><?= esc($section['slug']) ?></td>
                            <td class="primary"><?= esc($section['pages']) ?></td>
                            <td class="primary"><?= esc($section['hits']) ?></td>
                            <td class="primary"><?= esc($section['hits_page']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No popular sections found.</p>
        <?php endif; ?>

    </panel>

</section>
