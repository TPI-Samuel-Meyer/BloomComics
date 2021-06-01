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
            <button class='btn primary' onclick="location.href='index.php?action=add_artwork';">Add artwork</button>
            <button class='btn primary' onclick="location.href='index.php?action=modify_categories';">Modify categories</button>
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
    <select id='category_selector' onchange="category_filter();">
        <option value='' selected>Category</option>
        <?php if (!empty(select('name', 'categories'))) {
            foreach (select('name', 'categories') as $type) : ?>
                <option value='<?=$type[0];?>'><?=$type[0];?></option>
            <?php endforeach;
        } ?>
    </select>
    <span>
        <input oninput='search(this.value);' type='text' placeholder='Search by title or editor...'/>
    </span>
</form>

<?php
    // Select required data to display users
    $data = select('id, ui, title, description, editor, type', 'artworks');
    $categories = '';
    // Display artworks
    foreach($data as $key => $artwork) : ?>
    <?php
        if (!empty(select('category, artwork', 'category_as_artwork', ['artwork' => $artwork['id']]))) {
            $linkedCategories = select('category, artwork', 'category_as_artwork', ['artwork' => $artwork['id']]);
            foreach ($linkedCategories as $key => $value) {
                $prepCategories[] = select('name', 'categories', ['id' => $value['category']])[0][0];
            }
            $categories = implode(", ", $prepCategories);
        }
    ?>
    <div class='card' onclick="location.href='index.php?action=description&ui=<?=$artwork['ui'];?>';" editor='<?=$artwork['editor'];?>' categories="<?=$categories;?>">
        <img src='<?=check_img($artwork['ui']);?>'/>
        <span class='content'>
            <span class='title'><?=$artwork['title'];?></span>
            <small class='text'><?=$artwork['description'];?></small>
            <span style='color: blueviolet;'><?=select('name', 'types', array('id' => $artwork['type']))[0][0];?></span>
        </span>
    </div>
<?php endforeach; ?>
