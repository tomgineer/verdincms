<?= $this->include('dashboard/pages/subjects/header') ?>

<section class="grid grid-col-1 gap-05 mt-2">

    <panel class="tabpanel tabpanel--right tabpanel--light">

        <header class="flex flex-space gap-2 flex-vt">
            <div>
                <h3 class="tabpanel__title">Sections</h3>
                <p class="tabpanel__desc">Manage sections assigned to your pages.</p>
            </div>
            <a class="btn-outline fs-200 disabled" href="#" target="_blank">
                <svg class="svg-icon" aria-hidden="true">
                    <use href="#plus"></use>
                </svg>
                New Section
            </a>
        </header>

        <?php if (!empty($sections)): ?>
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Slug</th>
                        <th>Pages</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($sections as $section): ?>
                        <tr>
                            <td class="primary"><?= esc($section['id']) ?></td>
                            <td class="primary"><?= esc($section['title']) ?></td>
                            <td><?= strip_tags($section['description']) ?></td>
                            <td class="primary"><?= esc($section['slug']) ?></td>
                            <td class="primary"><?= esc($section['count']) ?></td>
                            <td class="primary">
                                <button type="button"
                                    data-modify-button="<?= esc($section['id']) ?>"
                                    data-target-modal="modalSections">
                                    Modify
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No sections found.</p>
        <?php endif; ?>

    </panel>


</section>

<?= $this->include('dashboard/pages/subjects/modal_sections') ?>