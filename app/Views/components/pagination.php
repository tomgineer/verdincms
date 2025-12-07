<?php if (!empty($pagination)): ?>
    <section class="mb-7 pagination flex justify-center">
        <div class="join">

            <!-- Back = Older posts -->
            <?php if ($pagination['older_exists']): ?>
                <a href="<?= current_url() . '?page=' . ($pagination['page'] + 1) ?>"
                    class="join-item btn hover:btn-secondary"
                    title="Παλαιότερα άρθρα">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                </a>
            <?php endif; ?>

            <!-- Page indicator -->
            <button class="join-item btn pointer-events-none text-base-content/70 font-heading font-light">
                Σελίδα <?= esc($pagination['page']) ?> από <?= esc($pagination['total_pages']) ?>
            </button>

            <!-- Home -->
            <?php if ($pagination['page'] > 1): ?>
                <a href="<?= current_url() ?>"
                    class="join-item btn hover:btn-secondary"
                    title="Αρχική">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                </a>
            <?php endif; ?>

            <!-- Forward = Newer posts -->
            <?php if ($pagination['newer_exists']): ?>
                <a href="<?= current_url() . '?page=' . ($pagination['page'] - 1) ?>"
                    class="join-item btn hover:btn-secondary"
                    title="Νεότερα άρθρα">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                    </svg>
                </a>
            <?php endif; ?>

        </div>
    </section>
<?php endif; ?>