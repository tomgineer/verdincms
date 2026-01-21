<?php if (!empty($stats)): ?>
    <div class="stats grid grid-cols-2 grid-flow-row">
        <?php foreach ($stats as $stat): ?>
            <div class="stat stat-lg place-items-center">
                <div class="stat-title"><?= esc($stat['title']) ?></div>
                <div class="stat-value text-accent"><?= esc($stat['value']) ?></div>
                <div class="stat-desc"><?= esc($stat['desc']) ?></div>
            </div>
        <?php endforeach; ?>
        <div class="stat stat-lg place-items-center !border-r-0">
            <div class="stat-title">Public <?= esc($content_label) ?></div>
            <div class="stat-value"><?= esc($public_count) ?></div>
            <div class="stat-desc">Only Public</div>
        </div>
        <div class="stat stat-lg place-items-center !border-r-0">
            <div class="stat-title">Total <?= esc($content_label) ?></div>
            <div class="stat-value"><?= esc($total_count) ?></div>
            <div class="stat-desc">Regardless of status</div>
        </div>
    </div>
<?php endif; ?>
