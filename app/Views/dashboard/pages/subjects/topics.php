<?= $this->include('dashboard/pages/subjects/header') ?>

<section class="grid grid-col-1 gap-05 mt-2">

    <panel class="tabpanel">
        <header class="flex flex-space gap-2 flex-vt">
            <div>
                <h3 class="tabpanel__title">Topics</h3>
                <p class="tabpanel__desc">Manage topics assigned to your posts.</p>
            </div>
            <a class="btn-outline fs-200 disabled" href="#" target="_blank">
                <svg class="svg-icon" aria-hidden="true">
                    <use href="#plus"></use>
                </svg>
                New Topic
            </a>
        </header>

        <?php if (!empty($topics)): ?>
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Slug</th>
                        <th>Posts</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($topics as $topic): ?>
                        <tr>
                            <td class="primary"><?= esc($topic['id']) ?></td>
                            <td class="primary"><?= esc($topic['title']) ?></td>
                            <td><?= strip_tags($topic['description']) ?></td>
                            <td class="primary"><?= esc($topic['slug']) ?></td>
                            <td class="primary"><?= esc($topic['count']) ?></td>
                            <td class="primary">
                                <button type="button"
                                    data-modify-button="<?= esc($topic['id']) ?>"
                                    data-target-modal="modalTopics">
                                    Modify
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No topics found.</p>
        <?php endif; ?>

    </panel>

</section>

<?= $this->include('dashboard/pages/subjects/modal_topics') ?>