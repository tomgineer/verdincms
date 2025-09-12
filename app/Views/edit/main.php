<div class="w-full mx-auto px-4 lg:max-w-4xl mt-6">

    <div class="indicator w-full mb-6">
        <span class="indicator-item badge font-semibold" data-indicator="60">12</span>
        <textarea class="textarea textarea-primary bg-base-200 w-full resize-none overflow-hidden text-2xl font-semibold" name="title" placeholder="Title" data-autogrow="true"><?=esc($post['title'])?></textarea>
    </div>

    <div class="indicator w-full mb-6">
        <span class="indicator-item badge font-semibold" data-indicator="120">12</span>
        <textarea class="textarea textarea-secondary bg-base-200 w-full resize-none overflow-hidden text-xl" name="subtitle" placeholder="Subtitle" data-autogrow="true"><?=esc($post['subtitle'])?></textarea>
    </div>

    <div class="edit-body prose prose-neutral prose-xl leading-relaxed mx-auto w-full lg:max-w-[80ch]"></div>

    <!-- Start: Inputs -->
    <input type="hidden" name="id" value="<?=esc($post['id'])?>">
    <input type="hidden" name="body" value="<?=esc($post['body'])?>">
    <input type="hidden" name="photo" value="<?=esc($post['photo'])?>">
    <input type="hidden" name="words" value="<?=esc($post['words'])?>">
    <input type="hidden" name="status" value="<?=esc($post['status'])?>">
    <input type="hidden" name="created" value="<?=esc($post['created'])?>">
    <input type="hidden" name="highlight" value="<?=esc($post['highlight'])?>">
    <!-- End: Inputs -->

</div>