<?php
require_once "model/dbManager.php";
require_once "view/view_helper.php";

$action = $_GET['action'];
$editor = false;
if(str_contains($action, 'artwork')){
    if (str_contains($action, 'modify')){
        $data = select('id, ui, title, description, releaseDate, editor, type', 'artworks', ['ui' => $_GET['ui']])[0];
        $data['type'] = select('name', 'types', ['id' => $data['type']])[0][0];
    }
    $typeList = select('id, name', 'types');
    $categoriesList = select('id, name', 'categories');
    $editor = true;
}

if(str_contains($action, 'article')){
    if (str_contains($action, 'modify')){
        $data = select('id, ui, title, description, releaseDate', 'articles', ['ui' => $_GET['ui']])[0];
    }
}
?>
<form method='post' action='index.php?action=<?=$action;?><?php if (isset($_GET['ui'])) echo '&ui='. $_GET['ui'];?>' enctype="multipart/form-data">
    <label>
        <span>Title</span>
        <input name='title' type='text' value='<?php if (isset($data['title'])) echo $data['title'];?>' required/>
    </label>
    <label>
        <span>Release date</span>
        <input name='releaseDate' type='date' value='<?php if (isset($data['releaseDate'])) echo $data['releaseDate'];?>' required/>
    </label>

    <?php if (isset($typeList)) : ?>
        <select name='type' required>
            <option value='' <?php if (!isset($data['type'])) echo 'selected';?>>Select type</option>
            <?php foreach ($typeList as $type) : ?>
                <option value='<?=$type['id'];?>' <?php if (isset($data['type'])) if ($type['name'] == $data['type']) echo 'selected';?>><?=$type['name'];?></option>
            <?php endforeach; ?>
        </select>
    <?php endif; ?>

    <?php if (isset($categoriesList)) : ?>
        <select name='category'>
            <option value=''>Select category</option>
            <?php foreach ($categoriesList as $category) : ?>
                <option value='<?=$category['id'];?>'><?=$category['name'];?></option>
            <?php endforeach; ?>
        </select>
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
    <input type='reset' value='Cancel' onclick="location.href='index.php?action=artwork'"/>
    <input name='submit' type='submit' value='Confirm'/>
</form>
