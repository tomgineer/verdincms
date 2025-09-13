<header class="mt-10 mb-8">
    <h1 class="text-5xl mb-2">Popular Topics &amp; Sections</h1>
    <p class="text-base-content/70">Explore the most viewed topics and sections based on visitor activity.</p>
</header>

<section class="grid grid-cols-1 gap-16">
    <div class="p-0">
        <h3 class="text-3xl mb-1">Topics</h3>
        <p class="text-base-content/70 mb-4">Top topics based on post engagement.</p>

        <?php if (!empty($stats['topics'])): ?>
            <table class="table table-zebra-soft">
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
                            <td><?= esc($topic['slug']) ?></td>
                            <td><?= esc($topic['posts']) ?></td>
                            <td><?= esc($topic['hits']) ?></td>
                            <td><?= esc($topic['hits_post']) ?></td>
                            <td>
                                <a class="btn btn-sm hover:btn-primary" href="<?= site_url('topic/' . $topic['slug']) ?>" target="_blank">View</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No popular topics found.</p>
        <?php endif; ?>
    </div>

    <div class="p-0">
        <h3 class="text-3xl mb-1">Sections</h3>
        <p class="text-base-content/70 mb-4">Most visited sections based on page views.</p>

        <?php if (!empty($stats['sections'])): ?>
            <table class="table table-zebra-soft">
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
                            <td><?= esc($section['slug']) ?></td>
                            <td><?= esc($section['pages']) ?></td>
                            <td><?= esc($section['hits']) ?></td>
                            <td><?= esc($section['hits_page']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No popular sections found.</p>
        <?php endif; ?>
    </div>
</section>
