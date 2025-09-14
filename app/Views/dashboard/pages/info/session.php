<section class="mt-4">

    <h3 class="text-3xl mb-2">Session Variables</h3>
    <p class="text-base-content/70 mb-4">Currently stored session keys and values for the active user session.</p>

    <?php if (!empty($session_data)): ?>
        <table class="table table-zebra-soft">
            <thead>
                <tr>
                    <th>Property</th>
                    <th>Value</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($session_data as $label => $value): ?>
                    <tr>
                        <th><?=$label?></th>
                        <td><?=$value?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

</section>