<?php
/*
 * User: Samuel Meyer
 * Date: 20.05.2021
 */

require_once "view/view_helper.php";

// Select required data to display users
require_once "model/dbManager.php";
$data = select(['id', 'username', 'description'], 'users', array('id' => $_GET['id']))[0];

if($_GET['id'] == $_SESSION['id']) : ?>

<div class='description'>
    <img src='<?=check_img($data['id'] .'pp');?>'
        onclick="document.getElementById('import_ppup').style.display = 'block';"
    />
    <span class='content'>
        <h3 class='title'><?=$data['username'];?></h3>
    </span>
</div>
<form method='post' action='index.php?action=profile&id=<?=$_GET['id'];?>'>
    <textarea name='description'
        oninput="document.getElementById('description_submit').style.display = 'block';"
    ><?=$data['description'];?></textarea>
    <span><?=$errors['description'];?></span>
    <input id='description_submit' type='submit' value='Modify' style='display: none;'/>
</form>

<form id='import_ppup' class='ppup' method='post' action='index.php?action=profile&id=<?=$_GET['id'];?>' enctype="multipart/form-data" style='display: none;'>
    <input type='file' name='import'/>
    <input type='submit' value='Import'/>
</form>

<?php else : ?>

    <div class='description'>
        <img src='<?=check_img($data['id'] .'pp');?>'/>
        <span class='content'>
        <h3 class='title'><?=$data['username'];?></h3>
    </span>
        <?php if(isset($_SESSION['type'])){
            if($_SESSION['type'] == 1) : ?>
                <button>Remove</button>
            <?php endif;
        } ?>
    </div>

<?php endif; ?>
