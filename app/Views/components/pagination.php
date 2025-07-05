<section class="mb-7 pagination-wrapper">

    <div class="pagination">
        <?php if (!empty($pagination['older_exists'])): ?>
            <a class="pagination__button prev" href="<?= current_url() ?>?page=<?= $pagination['page'] + 1 ?>">Παλαιότερα</a>
        <?php endif; ?>

        <?php if ($pagination['page'] > 1): ?>
            <span class="pagination__page"><?= esc($pagination['page']) ?></span>
        <?php endif; ?>

        <?php if (!empty($pagination['newer_exists'])): ?>
            <a class="pagination__button next" href="<?= current_url() ?>?page=<?= $pagination['page'] - 1 ?>">Νεότερα</a>
        <?php endif; ?>
    </div>

</section>