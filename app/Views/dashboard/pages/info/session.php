<?= $this->include('dashboard/pages/info/header') ?>

<?php
    $accent_colors  = [950 => 'a100', 900 => 'a200', 100 => 'a400', 50 => 'a700'];
    $palette_colors = [50,100,200,300,400,500,600,700,800,900,950];
?>

<section class="grid grid-col-2 gap-05 grid-break-md mt-2">

    <panel class="tabpanel">
        <h3 class="tabpanel__title">Palette</h3>
        <p class="tabpanel__desc">Information about the color palette and supported classes.</p>
        <table class="dash-table dash-table--narrow">
            <thead>
                <tr>
                    <th>Type</th>
                    <?php foreach ($palette_colors as $color): ?>
                        <th class="text-center"><?= $color ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>color</td>
                    <?php foreach ($palette_colors as $color): ?>
                        <td class="text-center set-<?= $color ?>"><?= $color ?></td>
                    <?php endforeach; ?>
                </tr>

                <tr>
                    <td>accent</td>
                    <?php foreach ($palette_colors as $color): ?>
                        <?php
                            // Try to find if this $color has a corresponding accent value
                            $accent = array_search("a{$color}", $accent_colors); // inverse lookup
                        ?>
                        <?php if ($accent !== false): ?>
                            <td class="text-center bg-a<?= $color ?> color-blue-<?= $accent ?>">
                                a<?= $color ?>
                            </td>
                        <?php else: ?>
                            <td class="text-center disabled">—</td>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tr>

                <tr>
                    <td>red</td>
                    <?php foreach ($palette_colors as $color): ?>
                        <td class="text-center set-red-<?= $color ?>"><?= $color ?></td>
                    <?php endforeach; ?>
                </tr>

                <tr>
                    <td>orange</td>
                    <?php foreach ($palette_colors as $color): ?>
                        <td class="text-center set-orange-<?= $color ?>"><?= $color ?></td>
                    <?php endforeach; ?>
                </tr>

                <tr>
                    <td>green</td>
                    <?php foreach ($palette_colors as $color): ?>
                        <td class="text-center set-green-<?= $color ?>"><?= $color ?></td>
                    <?php endforeach; ?>
                </tr>

                <tr>
                    <td>blue</td>
                    <?php foreach ($palette_colors as $color): ?>
                        <td class="text-center set-blue-<?= $color ?>"><?= $color ?></td>
                    <?php endforeach; ?>
                </tr>
            </tbody>
        </table>
    </panel>

    <panel class="tabpanel tabpanel--right tabpanel--light">
        <h3 class="tabpanel__title">Session Data</h3>
        <p class="tabpanel__desc">Currently stored session keys and values for the active user session.</p>

        <?php if (!empty($session_data)): ?>
            <table class="dash-table dash-table--primary">
                <thead>
                    <tr>
                        <th>Property</th>
                        <th>Value</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($session_data as $label => $value): ?>
                        <tr>
                            <td class="primary"><?=$label?></td>
                            <td><?=$value?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

    </panel>

</section>