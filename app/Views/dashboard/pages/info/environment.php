<section class="grid grid-cols-2 gap-8 mt-4">

    <div>
        <h3 class="text-3xl mb-2">App & Server Environment</h3>
        <p class="text-base-content/70 mb-4">Overview of the app and server environment, including framework versions and key PHP settings, useful for debugging and maintenance.</p>

        <?php if (!empty($info['system'])): ?>
            <table class="table table-zebra-soft">
                <thead>
                    <tr>
                        <th>Property</th>
                        <th>Value</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($info['system'] as $label => $value): ?>
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
        <h3 class="text-3xl mb-2">Database Info</h3>
        <p class="text-base-content/70 mb-4">Key database connection details, including version, charset, time settings, and session-specific information.</p>

        <?php if (!empty($info['database'])): ?>
            <table class="table table-zebra-soft">
                <thead>
                    <tr>
                        <th>Property</th>
                        <th>Value</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($info['database'] as $label => $value): ?>
                        <tr>
                            <th><?=$label?></th>
                            <td><?=$value?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

    </div>

</section>



