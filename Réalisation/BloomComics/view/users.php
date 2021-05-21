<?php require_once "view/view_helper.php";?>

<?php
require_once "model/dbManager.php";
$data = select(['id', 'username', 'description'], 'users');
foreach($data as $key => $user) : ?>

    <a class='card' href='index?action=profile&id=<?=$user['id'];?>'>
        <img src='<?=check_img($user['id'] .'pp');?>' />
        <span class='content'>
            <span class='title'><?=$user['username'];?></span>
            <small class='text'><?=$user['description'];?></small>
        </span>
    </a>
<?php endforeach; ?>
