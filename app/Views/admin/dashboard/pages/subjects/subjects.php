<header class="mt-10 mb-4">
    <h1 class="text-5xl mb-2">Subjects</h1>
    <p class="text-base-content/70">Browse through the available topics and sections.</p>
</header>

<section class="tabs tabs-lg tabs-border">
    <input type="radio" name="subjects" class="tab" aria-label="Topics" checked="checked" />
    <div class="tab-content border-0 p-8">
        <p class="mb-2">Manage topics assigned to your posts.</p>
        <?= $this->include('admin/dashboard/pages/subjects/topics') ?>
    </div>

    <input type="radio" name="subjects" class="tab" aria-label="Sections" />
    <div class="tab-content border-0 p-8">
        <p class="mb-2">Manage sections assigned to your pages.</p>
        <?= $this->include('admin/dashboard/pages/subjects/sections') ?>
    </div>
</section>

<?= $this->include('admin/dashboard/pages/subjects/modal_topics') ?>
<?= $this->include('admin/dashboard/pages/subjects/modal_sections') ?>
