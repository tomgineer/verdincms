<?= $this->extend('frontend/layouts/default') ?>
<?= $this->section('main') ?>

<div class="container mx-auto px-4 mt-20 mb-24 flex justify-center">
    <div class="card max-w-5xl bg-base-200 card-xl shadow-sm border border-base-300">
        <div class="card-body text-center">

            <?php if ($success): ?>
                <div class="mb-4 text-warning">
                    <svg xmlns="http://www.w3.org/2000/svg" class="inline-block w-16 h-16" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0z" />
                    </svg>
                </div>
                <h2 class="card-title text-warning justify-center mb-2">
                    Επιτυχής Διαγραφή
                </h2>
                <p class="text-base-content/80"><?= esc($message) ?></p>
                <?php if (!empty($email)): ?>
                    <p class="mt-2 text-sm text-base-content/60"><?= esc($email) ?></p>
                <?php endif; ?>
                <div class="card-actions justify-end mt-6">
                    <a href="<?= site_url() ?>" class="btn btn-warning">Επιστροφή στην Αρχική</a>
                </div>

            <?php else: ?>
                <div class="mb-4 text-error">
                    <svg xmlns="http://www.w3.org/2000/svg" class="inline-block w-16 h-16" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0 3.75h.008v.008H12v-.008zM21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z" />
                    </svg>
                </div>
                <h2 class="card-title text-error justify-center mb-2">
                    Σφάλμα Διαγραφής
                </h2>
                <p class="text-base-content/80"><?= esc($message) ?></p>
                <div class="card-actions justify-end mt-6">
                    <a href="<?= site_url() ?>" class="btn btn-error">Πίσω στην Αρχική</a>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<?= $this->endSection() ?>
