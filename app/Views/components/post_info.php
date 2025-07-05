<div class="container container--sm mb-5">

    <section class="post__meta">

        <table class="meta-table">
            <tbody>
                <tr>
                    <td>Author</td>
                    <td>
                        <a href="<?= site_url('author/' . esc($post['user_handle'])) ?>"><?= esc($post['author']) ?></a>
                    </td>
                </tr>

                <tr>
                    <td>Published On</td>
                    <td><?=esc($post['f_created'])?></td>
                </tr>

                <tr>
                    <td>Reading Time</td>
                    <td><?=read_time(esc($post['words']))?>min</td>
                </tr>

                <tr>
                    <td>Topic</td>
                    <td>
                        <a href="<?= site_url('topic/' . esc($post['topic_slug'], 'url')) ?>"><?= esc($post['topic']) ?></a>
                    </td>
                </tr>

                <tr>
                    <td>Word Count</td>
                    <td><?=esc($post['words'])?></td>
                </tr>

                <?php if( tier() >= 10 ):?>
                    <tr>
                        <td>Views</td>
                        <td><?= esc($post['hits']) ?></td>
                    </tr>
                <?php endif;?>

                <tr>
                    <td>Visibility</td>
                    <td><?=(esc($post['accessibility'])==0?'Public':'Members Only')?></td>
                </tr>

            </tbody>
        </table>
    </section>
</div>