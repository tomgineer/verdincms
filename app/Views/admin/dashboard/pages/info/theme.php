<?php
    $themeTokens = [
        'primary' => [
            'css_var' => '--color-primary',
            'label'   => 'Primary brand color',
            'desc'    => 'The main color of your brand',
        ],
        'primary-content' => [
            'css_var' => '--color-primary-content',
            'label'   => 'Primary content color',
            'desc'    => 'Foreground color to use on primary color',
        ],

        'secondary' => [
            'css_var' => '--color-secondary',
            'label'   => 'Secondary brand color',
            'desc'    => 'Optional secondary color of your brand',
        ],
        'secondary-content' => [
            'css_var' => '--color-secondary-content',
            'label'   => 'Secondary content color',
            'desc'    => 'Foreground color to use on secondary color',
        ],

        'accent' => [
            'css_var' => '--color-accent',
            'label'   => 'Accent brand color',
            'desc'    => 'Optional accent color of your brand',
        ],
        'accent-content' => [
            'css_var' => '--color-accent-content',
            'label'   => 'Accent content color',
            'desc'    => 'Foreground color to use on accent color',
        ],

        'neutral' => [
            'css_var' => '--color-neutral',
            'label'   => 'Neutral dark color',
            'desc'    => 'For unsaturated UI areas',
        ],
        'neutral-content' => [
            'css_var' => '--color-neutral-content',
            'label'   => 'Neutral content color',
            'desc'    => 'Foreground color to use on neutral color',
        ],

        'base-100' => [
            'css_var' => '--color-base-100',
            'label'   => 'Base surface color',
            'desc'    => 'Used for blank backgrounds',
        ],
        'base-200' => [
            'css_var' => '--color-base-200',
            'label'   => 'Base color (darker)',
            'desc'    => 'Used to create elevation',
        ],
        'base-300' => [
            'css_var' => '--color-base-300',
            'label'   => 'Base color (darkest)',
            'desc'    => 'Used to create elevation',
        ],
        'base-content' => [
            'css_var' => '--color-base-content',
            'label'   => 'Base content color',
            'desc'    => 'Foreground color to use on base color',
        ],

        'info' => [
            'css_var' => '--color-info',
            'label'   => 'Info color',
            'desc'    => 'For informative/helpful messages',
        ],
        'info-content' => [
            'css_var' => '--color-info-content',
            'label'   => 'Info content color',
            'desc'    => 'Foreground color to use on info color',
        ],

        'success' => [
            'css_var' => '--color-success',
            'label'   => 'Success color',
            'desc'    => 'For success/safe messages',
        ],
        'success-content' => [
            'css_var' => '--color-success-content',
            'label'   => 'Success content color',
            'desc'    => 'Foreground color to use on success color',
        ],

        'warning' => [
            'css_var' => '--color-warning',
            'label'   => 'Warning color',
            'desc'    => 'For warning/caution messages',
        ],
        'warning-content' => [
            'css_var' => '--color-warning-content',
            'label'   => 'Warning content color',
            'desc'    => 'Foreground color to use on warning color',
        ],

        'error' => [
            'css_var' => '--color-error',
            'label'   => 'Error color',
            'desc'    => 'For error/danger/destructive messages',
        ],
        'error-content' => [
            'css_var' => '--color-error-content',
            'label'   => 'Error content color',
            'desc'    => 'Foreground color to use on error color',
        ],
    ];

?>

<section class="mt-4">

    <h3 class="text-3xl mb-2">Theme Palette</h3>
    <p class="text-base-content/70 mb-4">Information about the color palette and supported classes.</p>

    <table class="table table-zebra-soft">
        <thead>
            <tr>
                <th>Color</th>
                <th>Token</th>
                <th>CSS Variable</th>
                <th>Label</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($themeTokens as $token => $data): ?>
            <tr>
                <td>
                    <span
                        class="inline-block size-6 rounded border"
                        style="background: var(<?= esc($data['css_var']) ?>);"
                        title="<?= esc($data['css_var']) ?>"
                        aria-label="<?= esc($token) ?>"
                    ></span>
                </td>
                <th class="font-mono"><?= esc($token) ?></th>
                <td class="font-mono"><?= esc($data['css_var']) ?></td>
                <td><?= esc($data['label']) ?></td>
                <td class="text-base-content/70"><?= esc($data['desc']) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

</section>
