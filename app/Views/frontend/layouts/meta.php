<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="base-url" content="<?= base_url(); ?>">
<meta name="color-scheme" content="light dark">

<?php
    $metaItem = null;
    $metaUrl = null;
    $metaImageWidth = null;
    $metaImageHeight = null;

    if (!empty($post)) {
        $metaItem = $post;
        $metaUrl = site_url('post/' . $post['id']);
        $metaImageWidth = 512;
        $metaImageHeight = 512;
    } elseif (!empty($page)) {
        $metaItem = $page;
        $metaUrl = site_url($page['s_slug'] . '/' . $page['slug']);
        $metaImageWidth = 1536;
        $metaImageHeight = 649;
    }
?>

<?php if (!empty($metaItem)): ?>
    <title><?= htmlspecialchars($metaItem['title']) ?> | <?= setting('meta.siteName') ?></title>
    <meta name="description" content="<?= htmlspecialchars($metaItem['subtitle']) ?>" />

    <!-- Twitter Metas -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="<?= esc(setting('meta.twitter')) ?>">
    <meta name="twitter:title" content="<?= esc($metaItem['title']) ?>">
    <meta name="twitter:description" content="<?= esc(meta_description($metaItem['subtitle'], $metaItem['body'])) ?>">
    <meta name="twitter:creator" content="<?= esc(setting('meta.twitter')) ?>">
    <meta name="twitter:image" content="<?= esc(base_url('images/') . $metaItem['photo'] . '.webp') ?>">

    <!-- Open Graph data -->
    <meta property="og:description" content="<?= esc(meta_description($metaItem['subtitle'], $metaItem['body'])) ?>" />
    <meta property="og:url" content="<?= esc($metaUrl) ?>" />
    <meta property="og:title" content="<?= esc($metaItem['title']) ?>" />
    <meta property="og:type" content="article" />
    <meta property="og:image" content="<?= esc(base_url('images/') . $metaItem['photo'] . '.webp') ?>" />
    <meta property="og:image:width" content="<?= esc($metaImageWidth) ?>" />
    <meta property="og:image:height" content="<?= esc($metaImageHeight) ?>" />
    <meta property="og:site_name" content="<?= esc(setting('meta.siteName')) ?>" />
<?php else: ?>
    <?php $archiveDescription = !empty($site_desc) ? trim(strip_tags($site_desc)) : setting('meta.siteDescription'); ?>
    <title><?= (!empty($site_title) ? $site_title . ' | ' . setting('meta.siteName') : setting('meta.siteTitle')) ?></title>
    <meta name="description" content="<?= esc($archiveDescription) ?>" />
<?php endif; ?>
