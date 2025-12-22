<section class="mt-8 lg:mt-16">
    <div class="max-w-4xl mx-auto rounded-2xl bg-primary text-primary-content px-6 py-8 lg:px-10 lg:py-10 shadow-lg">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div class="space-y-2 lg:max-w-md">
                <h2 class="text-2xl lg:text-3xl font-semibold">
                    Μοιράσου το άρθρο με την παρέα σου!
                </h2>
                <p class="text-primary-content/80 text-sm lg:text-base">
                    Αν σου άρεσε αυτό που διάβασες, στείλτο με ένα κλικ σε φίλους, συναδέλφους ή στα social.
                </p>
            </div>

            <div class="w-full lg:max-w-md space-y-2">
                <label class="text-xs tracking-wide text-primary-content/70">
                    ΣΥΝΔΕΣΜΟΣ ΑΡΘΡΟΥ
                </label>

                <div class="join w-full">
                    <input
                        type="text"
                        class="input input-primary input-bordered join-item w-full text-sm font-mono focus:outline-none"
                        value="<?= current_url() ?>"
                        readonly>
                    <button
                        type="button"
                        class="btn btn-secondary join-item whitespace-nowrap"
                        data-js-copy-url>
                        Αντιγραφή
                    </button>
                </div>

                <p class="text-xs text-primary-content/70">
                    Πάτα «Αντιγραφή» ή κάνε <span class="kbd kbd-xs">Ctrl</span>+<span class="kbd kbd-xs">C</span> για να μοιραστείς τον σύνδεσμο.
                </p>
            </div>
        </div>
    </div>
</section>