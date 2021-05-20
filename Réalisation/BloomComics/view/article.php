<?php
require_once "model/dbManager.php";
require_once "view/view_helper.php";
$data = select(['ui', 'title', 'description', 'releaseDate', 'author'], 'articles', array('ui' => $_GET['ui']))[0];
$page = $data['title'];
?>
<div class='description'>
    <img src='<?=check_img($data['ui']);?>' />
    <span class='content'>
    <h3 class='title'><?=$data['title'];?></h3>
    <span>Writed by <?=select('username', 'users', array('id' => $data['author']))[0][0];?></span>
    <br/>
    <span><?=$data['releaseDate'];?></span>
    <br/>
    <span>
        <select>
            <option value='' selected>Mark article</option>
            <option value='10'>10 - Masterpiece</option>
            <option value='9'>9 - </option>
            <option value='8'>8 - </option>
            <option value='7'>7 - </option>
            <option value='6'>6 - </option>
            <option value='5'>5 - </option>
            <option value='4'>4 - </option>
            <option value='3'>3 - </option>
            <option value='2'>2 - </option>
            <option value='1'>1 - </option>
        </select>
    </span>
</span>
    <?php if(isset($_SESSION['type'])){
        if($_SESSION['type'] == 1) : ?>
            <button>Modify</button>
            <button>Remove</button>
        <?php endif;
    } ?>
</div>
<p><?=$data['description'];?></p>