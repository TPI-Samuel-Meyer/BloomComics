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
    <div class="menu">
    </div>
</div>
<div class="content">
    <?=$content;?>
</div>
</body>
</html>
