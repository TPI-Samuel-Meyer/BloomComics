<?php
/*
 * User: Samuel Meyer
 * Date: 20.05.2021
 */

require_once "view/view_helper.php";

// Select required data to display users
require_once "model/dbManager.php";
$data = select(['id', 'username', 'description'], 'users', array('id' => $_GET['id']))[0];
if (isset($_SESSION['id']))
    if (!empty(select('status', 'user_as_user', ['user2' => $_SESSION['id']])))
        if (select('status', 'user_as_user', ['user2' => $_SESSION['id']])[0][0] == 0)
            $notifications = count(select('status', 'user_as_user', ['user2' => $_SESSION['id']]));

if($_GET['id'] == $_SESSION['id']) : ?>

<div class='description'>
    <img src='<?=check_img($data['id'] .'pp');?>'
        onclick="document.getElementById('import_ppup').style.display = 'block';"
    />
    <span class='content'>
        <h3 class='title'><?=$data['username'];?></h3>
    </span>
    <span>
        <button class='btn primary' onclick="location.href='index.php?action=friends';">Friends<?php if (isset($notifications)) {echo ' ('. $notifications .')';}?></button>
    </span>
</div>
<form method='post' action='index.php?action=profile&id=<?=$_GET['id'];?>'>
    <textarea name='description'
        oninput="document.getElementById('description_submit').style.display = 'block';"
    ><?=$data['description'];?></textarea>
    <span><?=$errors['description'];?></span>
    <input id='description_submit' type='submit' value='Modify' style='display: none;'/>
</form>

<form id='import_ppup' class='ppup' method='post' action='index.php?action=profile&id=<?=$_GET['id'];?>' enctype="multipart/form-data" style='display: none;'>
    <input type='file' name='import'/>
    <input type='submit' value='Import'/>
</form>

<?php else : ?>

    <div class='description'>
        <img src='<?=check_img($data['id'] .'pp');?>'/>
        <span class='content'>
        <h3 class='title'><?=$data['username'];?></h3>
    </span>
        <?php if (isset($_SESSION['id'])) {
            if ($_SESSION['id'] !== $_GET['id']) {
                if (empty(select('id', 'user_as_user', ['user1' => $_SESSION['id']]))) : ?>
                    <?php if (!empty(select('status', 'user_as_user', ['user1' => $_GET['id'], 'user2' => $_SESSION['id']]))) : ?>
                        <?php if (select('status', 'user_as_user', ['user1' => $_GET['id'], 'user2' => $_SESSION['id']])[0][0] == 0) : ?>
                            <button class='btn primary' onclick="location.href='index.php?action=accept_request&id=<?=$_GET['id'];?>';">Accept</button>
                            <button class='btn secondary' onclick="location.href='index.php?action=reject_request&id=<?=$_GET['id'];?>';">Reject</button>
                        <?php else: ?>
                            <button class='btn primary'>Followed</button>
                        <?php endif; ?>
                    <?php else : ?>
                        <form method='post' action='index.php?action=profile&id=<?=$_GET['id'];?>'>
                            <button class='btn primary' type='submit' name='friend_request'>Send a friend request</button>
                        </form>
                    <?php endif; ?>
                <?php else : ?>
                    <?php if (!empty(select('status', 'user_as_user', ['user2' => $_GET['id'], 'user1' => $_SESSION['id']]))) : ?>
                        <?php if (select('status', 'user_as_user', ['user2' => $_GET['id'], 'user1' => $_SESSION['id']])[0][0] == 1) : ?>
                            <button class='btn primary'>Followed</button>
                        <?php else : ?>
                            <button class='btn third'>Friend request sent</button>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endif;
            }
        } ?>
        <?php if (isset($_SESSION['type'])){
            if ($_SESSION['type'] == 1) : ?>
                <button>Remove</button>
            <?php endif;
        } ?>
    </div>

<?php endif; ?>
