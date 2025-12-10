<section class="bg-gradient-to-br from-primary via-primary/70 to-secondary text-base-content">
    <div class="max-w-5xl mx-auto px-8 py-16 flex flex-col md:flex-row items-center gap-12">

        <div class="flex-1 text-center md:text-left">
            <h1 class="text-4xl md:text-5xl font-bold mb-6 bg-gradient-to-r from-accent to-secondary bg-clip-text text-transparent">
                Newsletter
            </h1>
            <p class="text-lg leading-relaxed opacity-90">
                Εγγράψου δωρεάν στο Newsletter της σελίδας! <span class="font-semibold">Κάθε Σαββατοκύριακο</span> στέλνω μια επιλεγμένη σύνοψη με τα πιο πρόσφατα άρθρα,
                μαζί με αποκλειστικό περιεχόμενο που δεν μπορώ να δημοσιεύσω εδώ λόγω λογοκρισίας.
            </p>
        </div>

        <form
            id="newsletter-form"
            class="flex-1 w-full max-w-md bg-base-200/20 backdrop-blur-lg rounded-2xl p-6 shadow-xl flex flex-col gap-4">
            <input type="text" name="hp_newsletter" class="hidden" autocomplete="off" tabindex="-1" aria-hidden="true">

            <input
                type="email"
                name="email"
                placeholder="Ρίξε το email σου..."
                class="input input-lg w-full bg-transparent border-0 border-b-2 border-base-content/30 rounded-none
               focus:border-accent focus:outline-none text-base-content placeholder:text-base-content/50 transition-all duration-200"
                required disabled/>

            <button type="submit" class="btn btn-accent btn-lg w-full shadow-md hover:shadow-accent/30 transition-all duration-200" disabled="disabled">
                Εγγραφή
            </button>

            <p id="newsletter-message" class="text-sm text-center opacity-70">
                Χωρίς spam. Μπορείς να διαγραφείς <br>ανά πάσα στιγμή με ένα κλικ.
            </p>
        </form>

    </div>
</section>