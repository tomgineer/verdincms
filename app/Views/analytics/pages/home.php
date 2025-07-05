<header class="dash-page-header">
    <div>
        <h1 class="ff-body fw-500 ls-1 mb-0">Analytics</h1>
        <p class="color-300 mb-0 lh-150">A complete overview of website traffic, user activity, published content, and system performance, providing key insights at a glance.</p>
    </div>
</header>

<section class="dash-display mt-2">
    <div class="dash-display__card">
        <span class="dash-display__value color-red-300" data-dash-count-up="<?=$live['usersOnline']?>">0</span>
        <span class="dash-display__label">Visitors Now</span>
    </div>
    <div class="dash-display__card">
        <span class="dash-display__value color-green-300" data-dash-count-up="<?=$live['visitorsToday']?>">0</span>
        <span class="dash-display__label">Visitors Today</span>
    </div>
    <div class="dash-display__card">
        <span class="dash-display__value color-blue-300" data-dash-count-up="<?=$live['hitsToday']?>">0</span>
        <span class="dash-display__label">Hits Today</span>
    </div>

</section>

<section class="grid grid-col-2 gap-05 grid-break-md mt-2">

    <panel class="tabpanel">
        <h3 class="tabpanel__title">Averages</h3>
        <p class="tabpanel__desc">Average visitor and hit counts per day, month, and year.</p>

        <table class="dash-table">
            <tbody>
                <?php foreach ($stats['averages'] as $label => $value): ?>
                    <tr>
                        <td><?= esc($label) ?></td>
                        <td class="primary"><?= esc($value) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </panel>

    <panel class="tabpanel tabpanel--light tabpanel--right mt-1">
        <h3 class="tabpanel__title">Growth</h3>
        <p class="tabpanel__desc">Comparison of recent visitor activity and overall view count trends.</p>

        <table class="dash-table">
            <tbody>
                <?php foreach ($stats['growth'] as $label => $value): ?>
                    <tr>
                        <td><?= esc($label) ?></td>
                        <td class="primary"><?= esc($value) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </panel>

    <panel class="panel panel--light">
        <h3 class="panel__title">Content</h3>
        <p class="panel__desc">Breakdown of all content on the website, including posts, pages, words, and uploaded media.</p>

        <table class="dash-table">
            <tbody>
                <?php foreach ($stats['content'] as $label => $value): ?>
                    <tr>
                        <td><?= esc($label) ?></td>
                        <td class="primary"><?= esc($value) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </panel>

    <panel class="panel">
        <h3 class="panel__title">Users</h3>
        <p class="panel__desc">Statistics on users, members, and estimated monthly/yearly revenue.</p>

        <table class="dash-table">
            <tbody>
                <?php foreach ($stats['users'] as $label => $value): ?>
                    <tr>
                        <td><?= esc($label) ?></td>
                        <td class="primary"><?= esc($value) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </panel>

    <panel class="panel">
        <h3 class="panel__title">System</h3>
        <p class="panel__desc">System performance and environment details.</p>

        <table class="dash-table">
            <tbody>
                <?php foreach ($stats['system'] as $label => $value): ?>
                    <tr>
                        <td><?= esc($label) ?></td>
                        <td class="primary"><?= esc($value) ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td>Rendered in</td>
                    <td class="primary">{elapsed_time} sec</td>
                </tr>
            </tbody>
        </table>
    </panel>

</section>
