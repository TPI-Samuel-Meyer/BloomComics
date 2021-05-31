<?php
/*
 * User: Samuel Meyer
 * Date: 31.05.2021
 */
require_once 'model/dbManager.php';
$data = select('id, name', 'categories');
?>

<button class='btn primary' onclick="document.getElementById('add_category').style.display = 'block';">Add</button>
<form class='vanished_field' id='add_category' method='post' action='index.php?action=add_category' style='display: none;'>
    <input name='name' type='text' placeholder='New category name...'/>
    <button onclick="document.getElementById('add_category').style.display = 'none';" class='btn secondary' type='reset'>Cancel</button>
    <button name='submit' class='btn primary' type='submit'>Confirm</button>
</form>

<div class='category_list'>
<?php foreach ($data as $key => $value) : ?>
    <div class='category_element'>
        <span><?=$value['name'];?>
            <button class='btn third' onclick="document.getElementById('modify_category_<?=$value['id'];?>').style.display = 'block';">Modify</button>
            <button class='btn secondary'
                    onclick="ppup_confirm('confirmation_ppup', 'index.php?action=remove_category&id=<?=$value['id'];?>', 'Are you sure you want remove this category?', 'All its articles and marks will be removed.', 1000);"
            >Remove</button>
            <form class='vanished_field' id='modify_category_<?=$value['id'];?>' method='post' action='index.php?action=modify_category&id=<?=$value['id'];?>' style='display: none;'>
                <input name='name' type='text' placeholder='New category name...' value='<?=$value['name'];?>'/>
                <button onclick="document.getElementById('modify_category_<?=$value['id'];?>').style.display = 'none';" class='btn secondary' type='reset'>Cancel</button>
                <button name='submit' class='btn primary' type='submit'>Confirm</button>
            </form>
        </span>
    </div>
<?php endforeach; ?>
</div>