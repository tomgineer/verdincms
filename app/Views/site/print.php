<!DOCTYPE html>
<html lang="<?=setting('site.language')?>">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?=htmlspecialchars($post['title'])?></title>
        <meta name="description" content="<?=htmlspecialchars($post['subtitle'])?>"/>
        <?= $this->include('components/favicon') ?>

        <style>
            @media print {
                body {
                    font-size: 14pt !important;
                    color: #000;
                    margin: 10mm !important;
                }
                table {
                    font-size: 12pt !important;
                }

            }

            body {
                font: Georgia, "Times New Roman", Times, serif;
                font-size: 18px;
                line-height: 1.6;
                color: #000;
                margin: 3rem 5rem;
            }

            @media(max-width: 750px) {
                body {margin: 1rem;}
            }

            h1, h2, h3 {
                line-height: 1.25;
                margin-top: 0;
                margin-bottom: 0.5em;
            }
            h5.section {
                font-size: 1.5em;
                line-height: 1.25;
                margin: 0.83em 0;
            }

            p {margin-top: 0;}
            a {color: #000 !important;}
            figure:not(.table), iframe, img:not(.qr-code) {display: none;}


            blockquote {
                border-left: 3px solid #000;
                padding: 0 1.5rem;
                font-style: italic;
                margin: 2rem;
            }
            .qr-code {
                width: 150px;
                height: 150px;
                image-rendering: pixelated; /* For most modern browsers */
                image-rendering: -moz-crisp-edges; /* For Firefox */
                image-rendering: crisp-edges; /* For older browsers */
            }
            .table {margin: 2rem 0;}
            .table table {
                border-collapse: collapse;
                border: 1px solid #000;
                margin: 0 auto;
            }
            .table th, .table td {
                border: 1px solid #000;
                padding: .25rem .5rem;
                text-align: left;
            }
            .table tr {page-break-inside: avoid;}
        </style>

    </head>
    <body class="<?=body_class()?>" data-theme="light" id="<?=body_class()?>">
        <h1><?=$post['title']?></h1>
        <hr>
        <h3><?=$post['subtitle']?></h3>
        <hr>
        <div><?=$post['body']?></div>
        <hr>
        <p><i><?=site_url('post/'.$post['id'])?></i></p>

        <?php if (qr_code_exists($post['id'])): ?>
            <img class="qr-code" src="<?= path_img().'qrcodes/'.'post_'.$post['id'].'.svg' ?>" alt="QR Code">
        <?php endif; ?>

    </body>
</html>