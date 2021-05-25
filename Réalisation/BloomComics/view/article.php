<?php
require_once "model/dbManager.php";
require_once "view/view_helper.php";
$data = select(['id', 'ui', 'title', 'description', 'releaseDate', 'author'], 'articles', array('ui' => $_GET['ui']))[0];
$data['mark'] = '';
if ( isset(select('mark', 'mark_as_article', array('article' => $data['id'],'author' => $_SESSION['id']))[0][0])){
    $data['mark'] = select('mark', 'mark_as_article', array('article' => $data['id'],'author' => $_SESSION['id']))[0][0];
}
$page = $data['title'];
?>
<div class='description'>
    <img src='<?=check_img($data['ui']);?>' />
    <span class='content'>
    <h3 class='title'><?=$data['title'];?></h3>
    <span>Added by <?=select('username', 'users', array('id' => $data['author']))[0][0];?></span>
    <br/>
    <span><?=$data['releaseDate'];?></span>
    <br/>
    <?php if(isset($_SESSION['username'])) : ?>
        <form id='mark_form' method='post' action='index?action=article&ui=<?=$data['ui'];?>'>
            <select name='mark' onchange="document.getElementById('mark_form').submit();">
                <option value='' <?php if (!isset($data['mark'])){echo 'selected';} ?>>Mark article</option>
                <option value='10' <?php if ($data['mark'] == 10){echo 'selected';} ?>>10 - Masterpiece</option>
                <option value='9' <?php if ($data['mark'] == 9){echo 'selected';} ?>>9 - </option>
                <option value='8' <?php if ($data['mark'] == 8){echo 'selected';} ?>>8 - </option>
                <option value='7' <?php if ($data['mark'] == 7){echo 'selected';} ?>>7 - </option>
                <option value='6' <?php if ($data['mark'] == 6){echo 'selected';} ?>>6 - </option>
                <option value='5' <?php if ($data['mark'] == 5){echo 'selected';} ?>>5 - </option>
                <option value='4' <?php if ($data['mark'] == 4){echo 'selected';} ?>>4 - </option>
                <option value='3' <?php if ($data['mark'] == 3){echo 'selected';} ?>>3 - </option>
                <option value='2' <?php if ($data['mark'] == 2){echo 'selected';} ?>>2 - </option>
                <option value='1' <?php if ($data['mark'] == 1){echo 'selected';} ?>>1 - </option>
            </select>
        </form>
    <?php endif; ?>
</span>
    <?php if(isset($_SESSION['type'])){
        if($_SESSION['type'] == 1) : ?>
            <button>Modify</button>
            <button>Remove</button>
        <?php endif;
    } ?>
</div>
<p><?=$data['description'];?></p>