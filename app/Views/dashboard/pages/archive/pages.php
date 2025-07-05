<?= $this->include('dashboard/pages/archive/header') ?>

<section class="grid grid-col-1 gap-05 mt-2">

    <panel class="tabpanel tabpanel--right tabpanel--light">

        <header class="flex flex-space gap-2 flex-vt">
            <div>
                <h3 class="tabpanel__title">Pages</h3>
                <p class="tabpanel__desc">All draft of deleted pages.</p>
            </div>
            <button class="btn-outline fs-200" data-dash-action="removeDeletedPages" data-dash-return="archive/pages">
                <svg class="svg-icon" aria-hidden="true">
                    <use href="#warning"></use>
                </svg>
                Purge Deleted Pages
            </button>
        </header>

        <?php if (!empty($pages)): ?>
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
                    <?php foreach ($pages as $page): ?>
                        <tr>
                            <td class="primary"><?= esc($page['id']) ?></td>
                            <td class="primary">
                                <?= esc($page['f_status']) ?>
                            </td>
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
            <p>No draft of deleted pages found.</p>
        <?php endif; ?>

    </panel>

</section>
