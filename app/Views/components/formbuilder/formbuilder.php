<?php foreach ($fields as $field): ?>

    <?php
        $name       = esc($field['name']);
        $label      = esc($field['label']);
        $comment    = !empty($field['comment']) ? '<span class="color-200 text-italic">(' . esc($field['comment']) . ')</span>' : '';
        $inputType  = esc($field['input_type']);
        $maxlength  = $field['length'] ? 'maxlength="' . esc($field['length']) . '"' : '';
    ?>
    <div class="formbuilder__fieldset <?=($inputType === 'hidden' ? 'hidden' : '')?>">
        <label class="formbuilder__label"><?= $label ?> <?= $comment ?></label>

        <?php switch ($inputType):
            case 'select': ?>
                <select name="<?= $name ?>" class="formbuilder__control" data-source="<?=esc($field['source'])?>">
                </select>
                <?php break; ?>

            <?php case 'textarea': ?>
                <textarea name="<?= $name ?>" class="formbuilder__control simple-editor" <?= $maxlength ?>></textarea>
                <?php break; ?>

            <?php case 'file': ?>
                <div class="formbuilder__fileset flex" data-form-file-dest="<?=esc($field['dest'])?>">
                    <input
                        type="text"
                        name="<?= $name ?>"
                        class="formbuilder__control formbuilder__file-display"
                        placeholder="<?= $label ?>"
                        readonly
                    />
                    <button class="formbuilder__button formbuilder__file-clear" type="button">
                        <svg class="svg-icon" aria-hidden="true">
                            <use href="#close"></use>
                        </svg>
                    </button>
                    <div class="formbuilder__upload">
                        <input
                            type="file"
                            name="<?= $name . '-input' ?>"
                            id="<?= $name . '-input'?>"
                            class="formbuilder__file">
                        <label class="formbuilder__button formbuilder__file-label" for="<?= $name . '-input' ?>">
                            <svg class="svg-icon" aria-hidden="true">
                                <use href="#upload"></use>
                            </svg>
                        </label>
                    </div>
                </div>
            <?php break; ?>

            <?php default: ?>
                <input
                    type="<?= $inputType ?>"
                    name="<?= $name ?>"
                    class="formbuilder__control"
                    placeholder="<?= $label ?>"
                    <?= $maxlength ?>
                />

        <?php endswitch; ?>
    </div>

<?php endforeach; ?>

