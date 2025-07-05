<!-- Twitter Metas -->
<meta name="twitter:card" content="summary">
<meta name="twitter:site" content="<?= esc(setting('meta.twitter')) ?>">
<meta name="twitter:title" content="<?= esc($page['title']) ?>">
<meta name="twitter:description" content="<?= esc(meta_description($page['subtitle'], $page['body'])) ?>">
<meta name="twitter:creator" content="<?= esc(setting('meta.twitter')) ?>">
<meta name="twitter:image" content="<?= esc(path_img_tn() . $page['photo'] . '.webp') ?>">

<!-- Open Graph data -->
<meta property="og:description" content="<?= esc(meta_description($page['subtitle'], $page['body'])) ?>" />
<meta property="og:url" content="<?= esc(site_url($page['s_slug'] . '/' . $page['slug'])) ?>" />
<meta property="og:title" content="<?= esc($page['title']) ?>" />
<meta property="og:type" content="article" />
<meta property="og:image" content="<?= esc(path_img_tn() . $page['photo'] . '.webp') ?>" />
<meta property="og:image:width" content="1344" />
<meta property="og:image:height" content="768" />
<meta property="og:site_name" content="<?= esc(setting('meta.site_name')) ?>" />
