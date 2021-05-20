<?php
require_once "view/view_helper.php";
if(isset($_SESSION['type'])){
    if($_SESSION['type'] == 1) : ?>
        <span>
            <button>Add artwork</button>
            <button>Modify categories</button>
        </span>
    <?php endif;
} ?>
<form>
    <select>
        <option value='' selected>Type</option>
    </select>
    <select>
        <option value='' selected>Category</option>
    </select>
    <select>
        <option value='' selected>Editor</option>
    </select>
    <span>
        <input type='text' placeholder='Search...'/>
    </span>
</form>

<?php
require_once "model/dbManager.php";
    $data = select(['ui', 'title', 'description', 'type'], 'artworks');
    foreach($data as $key => $artwork) : ?>

    <a class='card' href='index?action=description&ui=<?=$artwork['ui'];?>'>
        <img src='<?=check_img($artwork['ui']);?>' />
        <span class='content'>
            <span class='title'><?=$artwork['title'];?></span>
            <small class='text'><?=$artwork['description'];?></small>
            <span style='color: blueviolet;'><?=select('name', 'types', array('id' => $artwork['type']))[0][0];?></span>
        </span>
    </a>
<?php endforeach; ?>
