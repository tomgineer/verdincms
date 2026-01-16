<script>
    (function () {
        try {
            var root = document.documentElement;
            var saved = localStorage.getItem('theme_mode');
            var defaultTheme = root.getAttribute('data-default-theme') || root.getAttribute('data-theme');
            if (saved && (saved === defaultTheme || saved === 'corporate')) {
                root.setAttribute('data-theme', saved);
            }
        } catch (e) {}
    })();
</script>

<script src="<?= base_url('js/app-dist.js') . '?v=' . ver() ?>" defer></script>

<?php foreach (setting('system.extraJs') ?: [] as $js): ?>
    <script src="<?= base_url('js/' . $js . '-dist.js') . '?v=' . ver() ?>" defer></script>
<?php endforeach; ?>