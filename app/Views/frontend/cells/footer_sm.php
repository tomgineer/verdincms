<footer class="bg-base-200">
    <section class="flex p-6 items-center gap-4">
        <img class="size-12" src="<?= base_url('gfx/svg/vcms_icon.svg') ?>" alt="VerinCMS Icon" loading="lazy">

        <div class="flex-1">
            <div class="text-base-content/70 text-sm"><?=setting('system.cms')?> &copy; 2026 <?=setting('system.vendor')?>. All Rights Reserved.</div>
            <p class="text-xs md:text-sm text-base-content/40">
                Powered by <span class="text-base-content/70"><?=setting('system.cms')?></span>: <?= VERDINCMS_VERSION ?>
            </p>
        </div>

        <div class="text-base-content/40 text-sm mr-2 hidden md:flex md:gap-1.5 md:items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 13.5h3.86a2.25 2.25 0 0 1 2.012 1.244l.256.512a2.25 2.25 0 0 0 2.013 1.244h3.218a2.25 2.25 0 0 0 2.013-1.244l.256-.512a2.25 2.25 0 0 1 2.013-1.244h3.859m-19.5.338V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 0 0-2.15-1.588H6.911a2.25 2.25 0 0 0-2.15 1.588L2.35 13.177a2.25 2.25 0 0 0-.1.661Z" />
            </svg>
            <span class="text-base-content/70"><?=setting('system.vendorEmail')?></span>
        </div>

        <a href="#top" class="btn btn-circle btn-soft btn-lg hover:bg-primary" aria-label="Back to top" title="Back to top">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5 12 3m0 0 7.5 7.5M12 3v18" />
            </svg>
        </a>

    </section>
</footer>