<div class="container container--sm mb-5">

    <section class="post__meta">

        <table class="meta-table">
            <tbody>
                <tr>
                    <td>Author</td>
                    <td>
                        <a href="<?= site_url('author/' . esc($page['user_handle'])) ?>"><?= esc($page['author']) ?></a>
                    </td>
                </tr>

                <tr>
                    <td>Published On</td>
                    <td><?=esc($page['formatted_date'])?></td>
                </tr>

                <tr>
                    <td>Reading Time</td>
                    <td><?=read_time(esc($page['words']))?>min</td>
                </tr>

                <tr>
                    <td>Section</td>
                    <td>
                        <?= esc($page['section']) ?>
                    </td>
                </tr>

                <tr>
                    <td>Word Count</td>
                    <td><?=esc($page['words'])?></td>
                </tr>

                <tr>
                    <td>Views</td>
                    <td><?=esc($page['hits'])?></td>
                </tr>

                <tr>
                    <td>Visibility</td>
                    <td><?=(esc($page['accessibility'])==0?'Public':'Members Only')?></td>
                </tr>

            </tbody>
        </table>
    </section>
</div>
