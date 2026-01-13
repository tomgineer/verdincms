<link rel="stylesheet" href="<?= path_css() ?>tailwind.css?v=<?= ver() ?>">

<?php foreach (setting('theme.extraFonts') ?: ['default'] as $font): ?>
    <link rel="stylesheet" href="<?= base_url('assets/fonts/' . $font) ?>/fonts.css">
<?php endforeach; ?>

<link rel="icon" type="image/svg+xml" href="<?=base_url('gfx/favicon/favicon.svg')?>">
<link rel="icon" type="image/png" sizes="32x32" href="<?=base_url('gfx/favicon/favicon-32.png')?>">
<link rel="apple-touch-icon" sizes="180x180" href="<?=base_url('gfx/favicon/apple-touch-icon.png')?>">
<link rel="icon" href="<?=base_url('gfx/favicon/favicon.ico')?>">