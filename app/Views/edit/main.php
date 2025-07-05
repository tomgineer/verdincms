<div class="container">

    <div class="edit-text-area-wrapper">
        <textarea class="edit-textarea autogrow fs-700" name="title" rows="1" placeholder="Title" data-minlength="60"><?=esc($post['title'])?></textarea>
        <span class="char-count">0</span>
    </div>

    <div class="edit-text-area-wrapper">
        <textarea class="edit-textarea autogrow fs-600" name="subtitle" rows="1" placeholder="Subtitle" data-minlength="120"><?=esc($post['subtitle'])?></textarea>
        <span class="char-count">0</span>
    </div>

    <div class="edit-body"></div>

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