<button class="btn btn-soft hover:btn-primary justify-start" data-dash-action="incrementBuild" type="button">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5">
        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
        <path d="M3 12h6" />
        <path d="M6 9v6" />
        <path d="M18 19v-14l-4 4" />
    </svg>
    Increment Build
</button>
<p class="text-base-content/70">Increases the build number by 1 to ensure browsers load the latest JS, CSS, fonts, and other assets.</p>

<button class="btn btn-soft hover:btn-primary justify-start" data-dash-action="clearCache" type="button">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 3v1.5M4.5 8.25H3m18 0h-1.5M4.5 12H3m18 0h-1.5m-15 3.75H3m18 0h-1.5M8.25 19.5V21M12 3v1.5m0 15V21m3.75-18v1.5m0 15V21m-9-1.5h10.5a2.25 2.25 0 0 0 2.25-2.25V6.75a2.25 2.25 0 0 0-2.25-2.25H6.75A2.25 2.25 0 0 0 4.5 6.75v10.5a2.25 2.25 0 0 0 2.25 2.25Zm.75-12h9v9h-9v-9Z" />
    </svg>
    Purge Cache
</button>
<p class="text-base-content/70">Empties the cache to ensure fresh content is loaded.</p>

<button class="btn btn-soft hover:btn-primary justify-start" data-dash-action="runCron" type="button">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
    </svg>
    Run Cron Job
</button>
<p class="text-base-content/70">Manually triggers the Cron Job outside its scheduled execution.</p>

<button class="btn btn-soft hover:btn-primary justify-start" data-dash-action="systemMaintenance" type="button">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
    </svg>
    System Maintenance
</button>
<p class="text-base-content/70">Runs the Cron Job, removes orphaned images from posts, blocks, and avatars, deletes soft-deleted posts, pages, and users, and clears the cache.</p>

<button class="btn btn-soft hover:btn-primary justify-start" data-dash-action="toggleCache" type="button">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5">
        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
        <path d="M20 4v.01" />
        <path d="M20 20v.01" />
        <path d="M20 16v.01" />
        <path d="M20 12v.01" />
        <path d="M20 8v.01" />
        <path d="M8 4m0 1a1 1 0 0 1 1 -1h6a1 1 0 0 1 1 1v14a1 1 0 0 1 -1 1h-6a1 1 0 0 1 -1 -1z" />
        <path d="M4 4v.01" />
        <path d="M4 20v.01" />
        <path d="M4 16v.01" />
        <path d="M4 12v.01" />
        <path d="M4 8v.01" />
    </svg>
    <span data-dash-label>Cache is: <?= (setting('cache.enabled') === true ? 'Enabled' : 'Disabled') ?></span>
</button>
<p class="text-base-content/70">Enables or disables the system cache setting in settings.json</p>