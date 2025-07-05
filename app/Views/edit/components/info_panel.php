<panel class="edit-panel open" data-panel-id="edit-info">

    <div class="edit-panel__header">
        <h3>Content Info</h3>
    </div>

    <div class="edit-panel__body">

        <table class="edit-table">
            <tbody>
                <tr>
                    <td class="primary color-300">ID</td>
                    <td><?=esc($post['id'])?></td>
                </tr>
                <tr>
                    <td class="primary color-300">Type</td>
                    <td><?=esc(ucfirst($type))?></td>
                </tr>
                <tr>
                    <td class="primary color-300">Status</td>
                    <td data-info="status" class="color-<?=esc($statusColors[$post['status']])?>-300">
                        <?=esc($statusLabels[$post['status']] ?? 'Unknown')?>
                    </td>
                </tr>

                <?php if ( $type==='page'):?>
                    <tr>
                        <td class="primary color-300">Position</td>
                        <td>0</td>
                    </tr>
                <?php endif;?>

                <tr>
                    <td class="primary color-300">Hits</td>
                    <td><?=esc($post['hits'])?></td>
                </tr>
                <tr>
                    <td class="primary color-300">Words</td>
                    <td data-info="words"><?=esc($post['words'])?></td>
                </tr>
                <tr>
                    <td class="primary color-300">Characters</td>
                    <td data-info="chars">0</td>
                </tr>
                <tr>
                    <td class="primary color-300">Syntax Highlighting</td>
                    <td><?= esc($post['highlight'] == 1 ? 'Yes' : 'No') ?></td>
                </tr>

                <tr>
                    <td class="primary color-300">Created</td>
                    <td data-info="created"><?=esc(date('F j, Y', strtotime($post['created'])))?></td>
                </tr>
            </tbody>
        </table>

    </div>
</panel>