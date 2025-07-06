<?= $this->extend('layout_app') ?>
<?= $this->section('main') ?>

<!--<div class="container container--front mt-2 mt-sm-0 mb-7">
    <div class="frontpage">
        <div class="frontpage__main">
            </?= view('components/post_list', ['posts' => $latest_updates]) ?>

            </?php if (!empty($latest_updates['pagination']) && is_array($latest_updates['pagination'])): ?>
                <div class="mt-3">
                    </?= view('components/pagination', ['pagination' => $latest_updates['pagination']]) ?>
                </div>
            </?php endif; ?>
        </div>

        <aside class="frontpage__aside">
            <a class="promo-link" href="https://t.me/tomsnews" target="_blank">
                <img src="</?=path_gfx().'telegram.webp?v=3'?>" alt="Follow Us on Telegram" loading="lazy">
            </a>

            <h3 class="frontpage__title">Featured</h3>
            </?= view('components/plain_list', ['posts' => $featured['posts']]) ?>

            <a class="promo-link" href="https://x.com/tomsnews_blog" target="_blank">
                <img src="</?=path_gfx().'twitter.webp?v=3'?>" alt="Follow Us on Twitter (X)" loading="lazy">
            </a>

            <h3 class="frontpage__title">Trending</h3>
            </?= view('components/plain_list', ['posts' => $trending['posts']]) ?>

            <h3 class="frontpage__title">Popular</h3>
            </?= view('components/plain_list', ['posts' => $popular['posts']]) ?>
        </aside>

    </div>
</div>-->

<p>Hello World</p>

<button class="btn btn-active">Default</button>
<button class="btn btn-active btn-primary">Primary</button>
<button class="btn btn-active btn-secondary">Secondary</button>
<button class="btn btn-active btn-accent">Accent</button>
<button class="btn btn-active btn-info">Info</button>
<button class="btn btn-active btn-success">Success</button>
<button class="btn btn-active btn-warning">Warning</button>
<button class="btn btn-active btn-error">Error</button>

<h1 class="text-3xl font-bold underline text-blue-500 bg-violet-500 hover:bg-amber-300">
    Hello world!
</h1>

<?= $this->endSection() ?>
