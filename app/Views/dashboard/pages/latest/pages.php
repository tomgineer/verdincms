<?= $this->include('dashboard/pages/latest/header') ?>

<section class="grid grid-col-1 gap-05 mt-2">

    <panel class="tabpanel tabpanel--right tabpanel--light">
        <h3 class="tabpanel__title">Pages</h3>
        <p class="tabpanel__desc">Recently created site pages.</p>

        <?php if (!empty($pages)): ?>
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Subtitle</th>
                        <th>Slug</th>
                        <th>Section</th>
                        <th>Hits</th>
                        <th>Words</th>
                        <th>Created</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pages as $page): ?>
                        <tr>
                            <td><?= esc($page['title']) ?></td>
                            <td><?= esc($page['subtitle']) ?></td>
                            <td class="primary"><?= esc($page['slug']) ?></td>
                            <td class="primary"><?= esc($page['s_slug']) ?></td>
                            <td class="primary"><?= esc($page['hits']) ?></td>
                            <td class="primary"><?= esc($page['words']) ?></td>
                            <td class="primary"><?= esc($page['f_created']) ?></td>
                            <td class="primary"><a href="<?=site_url($page['s_slug'] . '/'. $page['slug'])?>" target="_blank">View</a></td>
                            <td class="primary"><a href="<?=site_url('admin/edit/page/'.$page['id'])?>" target="_blank">Modify</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        <?php else:?>
            <p>No recent pages found.</p>
        <?php endif; ?>

    </panel>

</section>
