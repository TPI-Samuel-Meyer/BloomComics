<?php
/*
 * User: Samuel Meyer
 * Date: 18.05.2021
 */

require_once "view/view_helper.php";
require_once "model/dbManager.php";
if(isset($_SESSION['type'])){
    if($_SESSION['type'] == 1) : ?>
        <span>
            <button onclick="location.href='index.php?action=add_artwork';">Add artwork</button>
            <button>Modify categories</button>
        </span>
    <?php endif;
} ?>
<form>
    <select id='type_selector' onchange="type_filter();">
        <option value='' selected>Type</option>
        <?php if (!empty(select('name', 'types'))) {
            foreach (select('name', 'types') as $type) : ?>
                <option value='<?=$type[0];?>'><?=$type[0];?></option>
            <?php endforeach;
        } ?>
    </select>
    <select>
        <option value='' selected>Category</option>
    </select>
    <span>
        <input oninput='search(this.value);' type='text' placeholder='Search by title or editor...'/>
    </span>
</form>

<?php
    // Select required data to display users
    $data = select(['ui', 'title', 'description', 'editor', 'type'], 'artworks');
    // Display artworks
    foreach($data as $key => $artwork) : ?>

    <a class='card' href='index.php?action=description&ui=<?=$artwork['ui'];?>' editor='<?=$artwork['editor'];?>'>
        <img src='<?=check_img($artwork['ui']);?>' />
        <span class='content'>
            <span class='title'><?=$artwork['title'];?></span>
            <small class='text'><?=$artwork['description'];?></small>
            <span style='color: blueviolet;'><?=select('name', 'types', array('id' => $artwork['type']))[0][0];?></span>
        </span>
    </a>
<?php endforeach; ?>
