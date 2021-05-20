<?php
require_once "model/dbManager.php";
require_once "view/view_helper.php";
$data = select(['id', 'username', 'description'], 'users', array('username' => $_SESSION['username']))[0];
var_dump($data);
?>
<div class='description'>
    <img src='<?=check_img($data['id']);?>' />
    <span class='content'>
        <h3 class='title'><?=$data['username'];?></h3>
    </span>
    <?php if(isset($_SESSION['type'])){
        if($_SESSION['type'] == 1) : ?>
            <button>Modify</button>
        <?php endif;
    } ?>
</div>
<p><?=$data['description'];?></p>