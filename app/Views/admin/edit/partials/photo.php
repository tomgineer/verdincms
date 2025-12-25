<div
    class="<?= ($type == 'post' ? 'aspect-square' : 'aspect-[21/9]') ?>
    w-full bg-contain bg-center bg-no-repeat bg-base-100 mt-4 border-8 border-base-100 relative"
    data-type="<?= esc($type) ?>"
    data-edit-photo>

    <input type="file" id="photoInput" accept="image/*" class="hidden">

    <!-- Spinner -->
    <span class="loading loading-ring loading-xl text-accent hidden" data-edit-photo-spinner></span>
</div>

<div class="text-xs text-base-content/70 mt-2 mb-4 mx-4">
    <?php if ($type === 'post'): ?>
        For best results, upload an image sized <span class="text-accent font-semibold">1024 × 1024</span> px
    <?php else: ?>
        For best results, upload an image sized <span class="text-accent font-semibold">2304 × 960</span> px<br>
        (<span class="text-info font-semibold">1536 × 640</span> px × 1.5 Upscale)
    <?php endif; ?>
</div>


