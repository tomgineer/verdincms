<header class="mt-10 mb-8">
    <h1 class="text-5xl mb-2">Sort</h1>
    <p class="text-base-content/70">
        You can easily rearrange your
        <span class="badge badge-dash badge-info font-mono">Pages</span>,
        <span class="badge badge-dash badge-accent font-mono">Topics</span>,
        and <span class="badge badge-dash badge-secondary font-mono">Sections</span> here.
    </p>
    <p class="text-base-content/60 text-sm mt-2">
        Simply drag and drop items to change their order. Your changes are saved automatically as soon as you release an item.
    </p>
</header>

<section class="grid grid-cols-3 gap-4">

    <!-- Topics -->
    <div class="bg-base-200 p-8 pb-12 rounded">
        <h3 class="text-2xl font-semibold mb-8 flex items-center gap-2">Topics</h3>

        <ul data-sortable-list="topics"
            class="w-full flex flex-col gap-2">
            <?php foreach ($tables['topics'] as $topic): ?>
                <li data-sortable-item data-id="<?= esc($topic['id']) ?>" draggable="true">
                    <button
                        type="button"
                        class="btn btn-soft w-full justify-between cursor-move select-none font-heading font-light"
                        title="Drag to reorder">
                        <span class="truncate text-left text-sm font-medium">
                            <?= esc($topic['title']) ?>
                        </span>
                        <span class="opacity-60">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1.5"
                                class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 5h.01M9 9h.01M9 13h.01M9 17h.01M15 5h.01M15 9h.01M15 13h.01M15 17h.01" />
                            </svg>
                        </span>
                    </button>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- Sections -->
    <div class="bg-base-200 p-8 pb-12 rounded">
        <h3 class="text-2xl font-semibold mb-8 flex items-center gap-2">Sections</h3>

        <ul data-sortable-list="sections"
            class="w-full flex flex-col gap-2">
            <?php foreach ($tables['sections'] as $section): ?>
                <li data-sortable-item data-id="<?= esc($section['id']) ?>" draggable="true">
                    <button
                        type="button"
                        class="btn btn-soft w-full justify-between cursor-move select-none font-heading font-light"
                        title="Drag to reorder">
                        <span class="truncate text-left text-sm font-medium">
                            <?= esc($section['title']) ?>
                        </span>
                        <span class="opacity-60">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1.5"
                                class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 5h.01M9 9h.01M9 13h.01M9 17h.01M15 5h.01M15 9h.01M15 13h.01M15 17h.01" />
                            </svg>
                        </span>
                    </button>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- Pages -->
    <div class="bg-base-200 p-8 pb-12 rounded">
        <h3 class="text-2xl font-semibold mb-8 flex items-center gap-2">Pages</h3>

        <ul data-sortable-list="pages"
            class="w-full flex flex-col gap-2">
            <?php foreach ($tables['pages'] as $page): ?>
                <li data-sortable-item data-id="<?= esc($page['id']) ?>" draggable="true">
                    <button
                        type="button"
                        class="btn btn-soft w-full justify-between cursor-move select-none font-heading font-light"
                        title="Drag to reorder">
                        <span class="truncate text-left text-sm font-medium">
                            <?= esc($page['title']) ?>
                        </span>
                        <span class="opacity-60">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1.5"
                                class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 5h.01M9 9h.01M9 13h.01M9 17h.01M15 5h.01M15 9h.01M15 13h.01M15 17h.01" />
                            </svg>
                        </span>
                    </button>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

</section>
