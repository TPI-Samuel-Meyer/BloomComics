<?php
require_once "model/dbManager.php";
$action = $_GET['action'];
if(str_contains($action, 'artwork')){
    if (str_contains($action, 'modify')){
        $data = select('id, ui, title, description, releaseDate, editor, type', 'artworks', ['id' => $_GET['id']])[0];
    }
    $data['type'] = select('name', 'types', ['id' => $data['type']])[0][0];
    $typeList = select('id, name', 'types');
    $categoriesList = select('id, name', 'categories');
    $editor = true;
}
?>
<form method='post' action='index.php?action=<?=$action;?><?php if (isset($_GET['id'])) echo '&id='. $_GET['id'];?>' enctype="multipart/form-data">
    <label>
        <span>Title</span>
        <input name='title' type='text' value='<?php if (isset($data['title'])) echo $data['title'];?>' required/>
    </label>
    <label>
        <span>Release date</span>
        <input name='releaseDate' type='date' value='<?php if (isset($data['releaseDate'])) echo $data['releaseDate'];?>' required/>
    </label>

    <?php if (isset($typeList)) : ?>
        <select name='type'>
            <option value='' <?php if (!isset($data['type'])) echo 'selected';?>>Select type</option>
            <?php foreach ($typeList as $type) : ?>
                <option value='<?=$type['id'];?>' <?php if ($type['name'] == $data['type']) echo 'selected';?>><?=$type['name'];?></option>
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
        <input name='editor' type='text' value='<?php if (isset($data['editor'])) echo $data['editor'];?>'/>
    <?php endif; ?>

    <input type='file' name='import' accept='image/png, image/jpeg, image/jpg'/>
    <label>
        <span>Description</span>
        <textarea name='description'><?php if (isset($data['description'])) echo $data['description'];?></textarea>
    </label>
    <input type='reset' value='Cancel'/>
    <input type='submit' value='Confirm'/>
</form>