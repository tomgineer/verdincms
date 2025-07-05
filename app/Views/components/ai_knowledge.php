<div class="ai">

    <div class="container container--xl">
        <h1>Project Ταχυγνώση</h1>
        <p>Ανακάλυψε κάθε μέρα ένα μυστικό της ιστορίας και μια ανακάλυψη που άλλαξε τα πάντα.</p>

        <section class="ai__section ai_news">
            <h2 class="ai__title">Η επιστήμη στην καθημερινότητά μας: Μια εντυπωσιακή ανακάλυψη</h2>
            <div class="ai__body"><?=$ai['invention']['body']?></div>
            <button class="ai__button" type="button" aria-expanded="false">Πλήρες κείμενο</button>
        </section>

        <section class="ai__section ai_forecast">
            <h2 class="ai__title">Μια ιστορική στιγμή που άφησε το σημάδι της</h2>
            <div class="ai__body" aria-expanded="false"><?=$ai['history']['body']?></div>
            <button class="ai__button" type="button" aria-expanded="false">Πλήρες κείμενο</button>
        </section>

        <p class="ai__updated">Τελευταία ανανέωση: <?=esc($ai['invention']['f_updated'])?></p>

    </div>

</div>