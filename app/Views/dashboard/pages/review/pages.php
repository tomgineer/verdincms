<?= $this->include('dashboard/pages/review/header') ?>

<section class="grid grid-col-1 gap-05 mt-2">

    <panel class="tabpanel tabpanel--right tabpanel--light">
        <h3 class="tabpanel__title">Pages</h3>
        <p class="tabpanel__desc">Site content pages requiring updates or approval.</p>

        <?php if (!empty($pages)): ?>
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>ID</th>
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
                    <?php foreach ($pages as $page): ?>
                        <tr>
                            <td class="primary"><?= esc($page['id']) ?></td>
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
        <?php else: ?>
            <p>No content pages requiring updates found.</p>
        <?php endif; ?>

    </panel>

</section>
