<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-8">

    <!-- Active Subscribers -->
    <div>
        <h2 class="text-success text-xl font-semibold mb-3">Active Subscribers</h2>
        <pre
            class="bg-base-200 p-4 rounded font-mono text-sm overflow-x-auto whitespace-pre-wrap border border-success"><?= esc(implode(",\n", $subscribers['active_subs'])) ?></pre>
    </div>

    <!-- Inactive Subscribers -->
    <div>
        <h2 class="text-warning text-xl font-semibold mb-3">Inactive Subscribers</h2>
        <pre
            class="bg-base-200 p-4 rounded font-mono text-sm overflow-x-auto whitespace-pre-wrap border border-warning"><?= esc(implode(",\n", $subscribers['inactive_subs'])) ?></pre>
    </div>

</div>
