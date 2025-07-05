<ul class="sortlist" data-sortbuilder-table="<?=$table?>">
    <?php foreach ($rows as $row):?>
        <li class="sortlist__item" data-id="<?=$row['id']?>" draggable="true">
            <svg class="svg-icon" aria-hidden="true">
                <use href="#grip"></use>
            </svg>
            <span><?=$row['title']?></span>
        </li>
    <?php endforeach;?>
</ul>