<header class="mt-10 mb-4">
    <h1 class="text-5xl mb-2">Analytics</h1>
    <p class="text-base-content/70">A complete overview of website traffic, user activity, published content, and system performance, providing key insights at a glance.</p>
</header>

<section class="mb-16 flex justify-center">
    <div class="stats grid-cols-3">
        <div class="stat">
            <div class="stat-title text-secondary text-lg">Visitors Now</div>
            <div class="stat-value text-secondary text-5xl leading-tight"><?=$live['usersOnline']?></div>
            <div class="stat-desc">Currently active on the site</div>
        </div>

        <div class="stat">
            <div class="stat-title text-success text-lg">Visitors Today</div>
            <div class="stat-value text-success text-5xl leading-tight"><?=$live['visitorsToday']?></div>
            <div class="stat-desc">Unique visitors so far</div>
        </div>

        <div class="stat">
            <div class="stat-title text-primary text-lg">Hits Today</div>
            <div class="stat-value text-primary text-5xl leading-tight"><?=$live['hitsToday']?></div>
            <div class="stat-desc">Total page views today</div>
        </div>
    </div>
</section>

<section class="grid grid-cols-2 gap-x-8 gap-y-16">
    <div class="rounded-lg p-8">
        <h3 class="text-3xl mb-1">Averages</h3>
        <p class="text-base-content/70 mb-4">Average visitor and hit counts per day, month, and year.</p>
        <table class="table table-zebra">
            <tbody>
                <?php foreach ($stats['averages'] as $label => $value): ?>
                    <tr>
                        <th><?= esc($label) ?></th>
                        <td class="primary"><?= esc($value) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="rounded-lg bg-info-content p-8">
        <h3 class="text-3xl mb-1">Growth</h3>
        <p class="text-base-content/70 mb-4">Comparison of recent visitor activity and overall view count trends.</p>
        <table class="table table-zebra-soft">
            <tbody>
                <?php foreach ($stats['growth'] as $label => $value): ?>
                    <tr>
                        <th><?= esc($label) ?></th>
                        <td class="primary"><?= esc($value) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="rounded-lg p-8 bg-info-content">
        <h3 class="text-3xl mb-1">Content</h3>
        <p class="text-base-content/70 mb-4">Breakdown of all content on the website, including posts, pages, words, and uploaded media.</p>
        <table class="table table-zebra-soft">
            <tbody>
                <?php foreach ($stats['content'] as $label => $value): ?>
                    <tr>
                        <th><?= esc($label) ?></th>
                        <td class="primary"><?= esc($value) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="rounded-lg p-8">
        <h3 class="text-3xl mb-1">Users</h3>
        <p class="text-base-content/70 mb-4">Statistics on users, members, and estimated monthly/yearly revenue.</p>
        <table class="table table-zebra">
            <tbody>
                <?php foreach ($stats['users'] as $label => $value): ?>
                    <tr>
                        <th><?= esc($label) ?></th>
                        <td class="primary"><?= esc($value) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="rounded-lg">
        <h3 class="text-3xl mb-1">System</h3>
        <p class="text-base-content/70 mb-4">System performance and environment details.</p>
        <table class="table table-zebra">
            <tbody>
                <?php foreach ($stats['system'] as $label => $value): ?>
                    <tr>
                        <th><?= esc($label) ?></th>
                        <td class="primary"><?= esc($value) ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <th>Rendered in</th>
                    <td class="primary">{elapsed_time} sec</td>
                </tr>
            </tbody>
        </table>
    </div>

</section>
