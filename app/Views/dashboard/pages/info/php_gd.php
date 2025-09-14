<section class="grid grid-cols-2 gap-8 mt-4">

    <div>
        <h3 class="text-3xl mb-2">PHP Info</h3>
        <p class="text-base-content/70 mb-4">Details about the PHP environment, version, configuration, and loaded extensions.</p>

        <?php if (!empty($php_info)): ?>
            <table class="table table-zebra-soft">
                <thead>
                    <tr>
                        <th>Property</th>
                        <th>Value</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($php_info as $label => $value): ?>
                        <tr>
                            <th><?=$label?></th>
                            <td><?=$value?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <div>
        <h3 class="text-3xl mb-2">GD Image Library Info</h3>
        <p class="text-base-content/70 mb-4">Information about the GD library version and supported image types.</p>

        <?php if (!empty($gd_info)): ?>
            <table class="table table-zebra-soft">
                <thead>
                    <tr>
                        <th>Property</th>
                        <th>Value</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($gd_info as $label => $value): ?>
                        <tr>
                            <th><?=$label?></th>
                            <td>
                                <?php if ($value == '1'):?>
                                    <span class="badge badge-dash badge-success">Yes</span>
                                <?php elseif($value == ''):?>
                                    <span class="badge badge-dash badge-error">No</span>
                                <?php else:?>
                                    <?=$value?>
                                <?php endif;?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

    </div>

</section>