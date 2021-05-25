<?php
require_once "model/dbManager.php";
require_once "view/view_helper.php";
$data = select(['id', 'ui', 'title', 'description', 'releaseDate', 'editor', 'type'], 'artworks', array('ui' => $_GET['ui']))[0];
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
        <button onclick="location.href='index?action=add_article&id=<?=$data['id'];?>';">Add an article</button>
    <?php endif;
    if(isset($_SESSION['type'])){
        if($_SESSION['type'] == 1) : ?>
            <button onclick="location.href='index?action=modify_artwork&id=<?=$data['id'];?>';">Modify</button>
            <button>Remove</button>
        <?php endif;
    } ?>
</div>

<?php require_once "model/dbManager.php";
$data = select(['ui', 'title', 'description'], 'articles', array('artwork' => select('id', 'artworks', array('ui' => $_GET['ui']))[0][0]));
foreach($data as $key => $article) : ?>
    <a class='card' href='index?action=article&ui=<?=$article['ui'];?>'>
        <img src='<?=check_img($article['ui']);?>' />
        <span class='content'>
            <span class='title'><?=$article['title'];?></span>
            <small class='text'><?=$article['description'];?></small>
            <span>#Mark</span>
        </span>
    </a>
<?php endforeach; ?>