<?php
/*
 * User: Samuel Meyer
 * Date: 10.05.2021
 */
require_once 'model/dbManager.php';
if (isset($_SESSION['id']))
    if (!empty(select('status', 'user_as_user', ['user2' => $_SESSION['id']])))
        if (select('status', 'user_as_user', ['user2' => $_SESSION['id']])[0][0] == 0)
            $notifications = count(select('status', 'user_as_user', ['user2' => $_SESSION['id']]));
 ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php if(isset($page)){echo $page;}else{ echo 'BloomComics';};?></title>
    <link href='https://fonts.googleapis.com/icon?family=Material+Icons' rel='stylesheet'>
    <link href='view/content/style/style.css' rel='stylesheet'>
</head>
<body>
    <div class='header'>
        <span class='brand'><a href='index.php?action=home'>BloomComics</a></span>
        <span class='nav-features'>
            <span class="tabbed-section__selector">
                <a class="tabbed-section__selector-tab" href='index.php?action=artwork'>Artwork</a>
                <?php if(isset($_SESSION['username'])) :?>
                <a class="tabbed-section__selector-tab" href='index.php?action=profile&id=<?=$_SESSION['id'];?>'>Profile<?php if (isset($notifications)) {echo ' ('. $notifications .')';}?></a>
                <a class="tabbed-section__selector-tab" href='index.php?action=users'>Users</a>
                <a class="tabbed-section__selector-tab" href='index.php?action=sign_out'>Sign out</a>
                <?php else : ?>
                <a class="tabbed-section__selector-tab" href='index.php?action=sign_in'>Sign in</a>
                <a class="tabbed-section__selector-tab" href='index.php?action=sign_up'>Sign up</a>
                <?php endif; ?>
            </span>
        </span>
    </div>
    <div class="content">
        <?=$content;?>
    </div>
    <script src='view/script/category.js'></script>
    <script src='view/script/pop-up.js'></script>
    <script src='view/script/searchbar.js'></script>
</body>
</html>
