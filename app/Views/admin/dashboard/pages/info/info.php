<header class="mt-10 mb-4">
    <h1 class="text-5xl mb-2">System Information</h1>
    <p class="text-base-content/70">Comprehensive overview of the PHP runtime, server configuration, and system capabilities.</p>
</header>

<section class="tabs tabs-lg tabs-border">
    <input type="radio" name="info" class="tab" aria-label="Environment" checked="checked" />
    <div class="tab-content border-0 p-8">
        <p class="mb-2 text-base-content/70">Core versions, environment details, and runtime settings.</p>
        <?= $this->include('admin/dashboard/pages/info/environment') ?>
    </div>

    <input type="radio" name="info" class="tab" aria-label="PHP & GD Library" />
    <div class="tab-content border-0 p-8">
        <p class="mb-2 text-base-content/70">PHP runtime details and GD image library support.</p>
        <?= $this->include('admin/dashboard/pages/info/php_gd') ?>
    </div>

    <input type="radio" name="info" class="tab" aria-label="Session Variables" />
    <div class="tab-content border-0 p-8">
        <p class="mb-2 text-base-content/70">Active session variables and values.</p>
        <?= $this->include('admin/dashboard/pages/info/session') ?>
    </div>

    <input type="radio" name="info" class="tab" aria-label="Theme Palette" />
    <div class="tab-content border-0 p-8">
        <p class="mb-2 text-base-content/70">Current theme color palette and design tokens.</p>
        <?= $this->include('admin/dashboard/pages/info/theme') ?>
    </div>
</section>
