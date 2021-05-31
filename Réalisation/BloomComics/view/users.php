<?php
/*
 * User: Samuel Meyer
 * Date: 21.05.2021
 */

require_once "view/view_helper.php";
$manage = false;

// Select required data to display users
require_once "model/dbManager.php";
if ($_GET['action'] == 'users') {
    $data = select(['id', 'username', 'description'], 'users');
}
elseif ($_GET['action'] == 'friends') {
    $manage = true;
    $relations = [];
    if (!empty(select('user2', 'user_as_user', ['user1' => $_SESSION['id']]))) $relations[] = select('user2', 'user_as_user', ['user1' => $_SESSION['id']]);
    if (!empty(select('user1', 'user_as_user', ['user2' => $_SESSION['id']]))) $relations[] = select('user1', 'user_as_user', ['user2' => $_SESSION['id']]);

    $data = [];
    if (!empty($relations))
        foreach ($relations[0] as $key => $value)
            if (!empty(select(['id', 'username', 'description'], 'users', ['id' => $relations[0][$key][0]]))) $data[] = select(['id', 'username', 'description'], 'users', ['id' => $relations[0][$key][0]]);
    if (empty($relations)) echo "You can send friend requests to users interesting you.";
}

foreach($data as $key => $user) : ?>
    <?php if ($_GET['action'] == 'friends') $user = $user[0]; ?>
    <a class='card' href='index.php?action=profile&id=<?=$user['id'];?>'>
        <img src='<?=check_img($user['id'] .'pp');?>'/>
        <span class='content'>
            <?php if ($manage) : ?>
                <?php if (!empty(select('status', 'user_as_user', ['user2' => $_SESSION['id'], 'user1' => $user['id']]))) : ?>
                    <?php if (select('status', 'user_as_user', ['user2' => $_SESSION['id'], 'user1' => $user['id']])[0][0] == 0) : ?>
                        <button class='btn primary' onclick="location.href='index.php?action=accept_request&id=<?=$user['id'];?>';">Accept</button>
                        <button class='btn secondary' onclick="location.href='index.php?action=reject_request&id=<?=$user['id'];?>';">Reject</button>
                    <?php else: ?>
                        <span class='title'><?=$user['username'];?></span>
                        <small class='text'><?=$user['description'];?></small>
                    <?php endif; ?>
                <?php elseif (!empty(select('status', 'user_as_user', ['user1' => $_SESSION['id'], 'user2' => $user['id']]))) : ?>
                    <?php if (select('status', 'user_as_user', ['user1' => $_SESSION['id'], 'user2' => $user['id']])[0][0] == 0) : ?>
                        <button class='btn third'>Friend request sent</button>
                    <?php else: ?>
                        <span class='title'><?=$user['username'];?></span>
                        <small class='text'><?=$user['description'];?></small>
                    <?php endif; ?>
                <?php endif; ?>
            <?php else : ?>
                <span class='title'><?=$user['username'];?></span>
                <small class='text'><?=$user['description'];?></small>
            <?php endif; ?>
        </span>
    </a>
<?php endforeach; ?>
