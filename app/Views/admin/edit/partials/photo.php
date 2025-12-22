<div
    class="<?=($type=='post'?'aspect-square':'aspect-[21/9]')?>
    w-full bg-contain bg-center bg-no-repeat bg-base-100 my-4 border-8 border-base-100 relative"
    data-type="<?=esc($type)?>"
    data-edit-photo>

    <input type="file" id="photoInput" accept="image/*" class="hidden">

    <!-- Spinner -->
    <span class="loading loading-ring loading-xl text-accent hidden" data-edit-photo-spinner></span>
</div>
