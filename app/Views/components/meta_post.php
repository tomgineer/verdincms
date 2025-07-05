<!-- Twitter Metas -->
<meta name="twitter:card" content="summary">
<meta name="twitter:site" content="<?= esc(setting('twitter_alias')) ?>">
<meta name="twitter:title" content="<?= esc($post['title']) ?>">
<meta name="twitter:description" content="<?= esc(meta_description($post['subtitle'], $post['body'])) ?>">
<meta name="twitter:creator" content="<?= esc(setting('twitter_alias')) ?>">
<meta name="twitter:image" content="<?= esc(path_img_tn().$post['photo'].'.webp') ?>">

<!-- Open Graph data -->
<meta property="og:description" content="<?= esc(meta_description($post['subtitle'], $post['body'])) ?>" />
<meta property="og:url" content="<?= esc(site_url('post/'.$post['id'])) ?>" />
<meta property="og:title" content="<?= esc($post['title']) ?>" />
<meta property="og:type" content="article" />
<meta property="og:image" content="<?= esc(path_img_tn().$post['photo'].'.webp') ?>" />
<meta property="og:image:width" content="512" />
<meta property="og:image:height" content="512" />
<meta property="og:site_name" content="<?= esc(setting('site_name')) ?>" />
