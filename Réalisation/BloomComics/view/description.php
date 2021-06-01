<?php
/*
 * User: Samuel Meyer
 * Date: 20.05.2021
 */

require_once "model/dbManager.php";
require_once "view/view_helper.php";
$data = select(['id', 'ui', 'title', 'description', 'releaseDate', 'editor', 'type'], 'artworks', ['ui' => $_GET['ui']])[0];
$page = $data['title'];
?>
<div class='description'>
    <img src='<?=check_img($data['ui']);?>' />
    <span class='content'>
        <h3 class='title'><?=$data['title'];?></h3>
        <span><?=select('name', 'types', array('id' => $data['type']))[0][0];?></span>
        <br/>
        <span><?=$data['releaseDate'];?></span>
        <br/>
        <span><?=$data['editor'];?></span>
        <br/>
        <p><?=$data['description'];?></p>
    </span>
    <?php if(isset($_SESSION['username'])) : ?>
        <button class='btn primary' onclick="location.href='index.php?action=add_article&ui=<?=$data['ui'];?>';">Add an article</button>
    <?php endif;
    if(isset($_SESSION['type'])){
        if($_SESSION['type'] == 1) : ?>
            <button class='btn third' onclick="location.href='index.php?action=modify_artwork&ui=<?=$data['ui'];?>';">Modify</button>
            <button class='btn secondary'
                    onclick="ppup_confirm('confirmation_ppup', 'index.php.php?action=remove_artwork&ui=<?=$data['ui'];?>', 'Are you sure you want remove this artwork?', 'All its articles and marks will be removed.', 1000);"
            >Remove</button>
        <?php endif;
    } ?>
</div>

<?php
$data = select(['ui', 'title', 'description'], 'articles', array('artwork' => select('id', 'artworks', ['ui' => $_GET['ui']])[0][0]));

foreach($data as $key => $article) : ?>
    <?php
        $query = "SELECT `article`,avg(`mark`) AS `AVG(mark)` from `mark_as_article` where `article` = ". select('id', 'articles', ['ui' => $article['ui']])[0][0] ." group by `article`;";
        require_once "model/dbConnector.php";
        global $db;
        if (!empty($db->select($query)[0]['AVG(mark)']))
            $data['AVGmark'] = number_format($db->select($query)[0]['AVG(mark)'], 1);
        else
            $data['AVGmark'] = 'N';
    ?>
    <div class='card' onclick="location.href='index.php?action=article&ui=<?=$article['ui'];?>';">
        <img src='<?=check_img($article['ui']);?>' />
        <span class='content'>
            <span class='title'><?=$article['title'];?></span>
            <small class='text'><?=$article['description'];?></small>
            <span><?=$data['AVGmark'];?>/10</span>
        </span>
    </div>
<?php endforeach; ?>