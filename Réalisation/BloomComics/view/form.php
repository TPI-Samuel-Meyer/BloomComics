<?php
/*
 * User: Samuel Meyer
 * Date: 18.05.2021
 */

require_once "view/view_helper.php";

// Select required data to display users
require_once "model/dbManager.php";
$action = $_GET['action'];
$editor = false;

if(strpos($action, 'artwork') !== null){
    if (strpos($action, 'modify') !== null){
        $data = select('id, ui, title, description, releaseDate, editor, type', 'artworks', ['ui' => $_GET['ui']])[0];
        $data['type'] = select('name', 'types', ['id' => $data['type']])[0][0];
    }
    $typeList = select('id, name', 'types');
    $categoriesList = select('id, name', 'categories');
    $editor = true;
}

if(strpos($action, 'article') !== null){
    if (strpos($action, 'modify')){
        $data = select('id, ui, title, description, releaseDate', 'articles', ['ui' => $_GET['ui']])[0];
    }
}
?>
<form class='form-tmp' method='post' action='index.php?action=<?=$action;?><?php if (isset($_GET['ui'])) echo '&ui='. $_GET['ui'];?>' enctype="multipart/form-data">
    <label>
        <span>Title</span>
        <input name='title' type='text' value='<?php if (isset($data['title'])) echo $data['title'];?>' required/>
    </label>
    <label>
        <span>Release date</span>
        <input name='releaseDate' type='date' value='<?php if (isset($data['releaseDate'])) echo $data['releaseDate'];?>'/>
    </label>

    <?php if (isset($typeList)) : ?>
        <select name='type'>
            <option value='' <?php if (!isset($data['type'])) echo 'selected';?>>Select type</option>
            <?php foreach ($typeList as $type) : ?>
                <option value='<?=$type['id'];?>' <?php if (isset($data['type'])) if ($type['name'] == $data['type']) echo 'selected';?>><?=$type['name'];?></option>
            <?php endforeach; ?>
        </select>
    <?php endif; ?>

    <?php if (isset($categoriesList)) : ?>
        <select onchange='newCategoryElement(this.value);'>
            <option value=''>Select category</option>
            <?php foreach ($categoriesList as $category) : ?>
                <option id='cat-id-<?=$category['id'];?>' value='<?=$category['id'];?>'><?=$category['name'];?></option>
            <?php endforeach; ?>
        </select>
        <div id='category-list'></div>
    <?php endif; ?>

    <?php if ($editor) : ?>
        <label>
            <span>Editor</span>
            <input name='editor' type='text' value='<?php if (isset($data['editor'])) echo $data['editor'];?>'/>
        </label>
    <?php endif; ?>

    <?php if (isset($data['ui'])) if (check_img($data['ui']) == 'view/content/picture/none.jpg') : ?>
        <p>A picture is missing.</p>
    <?php else : ?>
        <img width='100px' height='auto' src='<?=check_img($data['ui']);?>'/>
    <?php endif; ?>
    <input type='file' name='import' accept='image/png, image/jpeg, image/jpg'/>
    <label>
        <span>Description</span>
        <textarea name='description'><?php if (isset($data['description'])) echo $data['description'];?></textarea>
    </label>
    <input class='btn primary' name='submit' type='submit' value='Confirm'/>
    <input class='btn secondary' type='reset' value='Cancel' onclick="location.href='index.php?action=artwork'"/>
</form>
