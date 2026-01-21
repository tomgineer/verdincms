<?php
    $emails = array_column($subscribers['active_subs'] ?? [], 'email');
    $emails = array_values(array_filter($emails, static fn($email) => !empty($email)));
    $list = implode("\n", $emails);
?>

<h3 class="text-2xl mb-4 pt-4">Active subscribers list</h3>
<p class="text-sm text-base-content/70 mb-3">One email per line (<?= count($emails) ?> total).</p>

<textarea class="textarea w-full min-h-[50vh] bg-base-200 focus:outline-0 focus:border-primary font-mono" readonly><?= esc($list) ?></textarea>

