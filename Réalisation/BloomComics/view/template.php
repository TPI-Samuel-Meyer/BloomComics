<?php
/*
 * User: Samuel Meyer
 * Date: 10.05.2021
 * Updated by:
 *
 */
 ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php if(isset($page)){echo $page;}else{ echo 'BloomComics';};?></title>
</head>
<body>
<div class="header">
    <a class='brand' href='index.php?action=home'>BloomComics</a>
    <a href='index.php?action=artwork'>Artwork</a>
    <?php if(isset($_SESSION['username'])) :?>
    <a href='index.php?action=profile'>Profile</a>
    <a href='index.php?action=users'>Users</a>
    <?php else : ?>
    <a href='index.php?action=sign_in'>Sign in</a>
    <a href='index.php?action=sign_up'>Sign up</a>
    <?php endif; ?>
</div>
<div class="content">
    <?=$content;?>
</div>
</body>
</html>
