<?php
/*
 * User: Samuel Meyer
 * Date: 18.05.20121
 */

/**
 * This function is designed to check and insert POST values for sign_up action.
 * @param $request : must be POST form array.
 */
function sign_up_check($request = []){
    require_once "model/dbManager.php";

    global $errors;
    $errors['username'] = '';
    $errors['email'] = '';
    $errors['password'] = '';

    if(
        !empty($request['username']) &&
        !empty($request['email']) &&
        !empty($request['password']) &&
        !empty($request['confirm'])
    ){
        $effective = true;

        // Check username constraints
        $username = $request['username'];
        $result = check_username($username);
        if($result !== true){$errors['username'] = $result; $effective = false;}

        // Check email constraints
        $email = $request['email'];
        $result = check_email($email);
        if($result !== true){$errors['email'] = $result; $effective = false;}

        // Check password constraints
        $password = $request['password'];
        $confirm = $request['confirm'];
        $result = check_password_constraints($password, $confirm);
        if($result !== true){$errors['password'] = $result; $effective = false;}

        if($effective){
            $data['username'] = $username;
            $data['email'] = $email;
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
            try{
                insert('users', $data);
                $_SESSION['notify'] = 'You are signed up! You can sign in now!';

                header('Location: index.php?action=sign_in');
                die();
            }catch(Exception $e){
                $_SESSION['notify'] = "An error occurred. Try again later please.";
                sign_up();
            }
        }else{
            sign_up();
        }
    }else{
        sign_up();
    }
}

/**
 * This function is designed to check email constraints.
 * @param $email : must be a string.
 * @return boolean : true or false.
 */
function check_email($email){
    require_once "model/dbManager.php";

    // Check if email is already registered in DB.
    if(isset(select('email', 'users', array('email' => $email))[0]['email'])){
        return 'Please, try another email, this one is already signed up.';
    }
    return true;
}

/**
 * This function is designed to check username constraints.
 * @param $username : must be a string.
 * @return boolean : true or false.
 */
function check_username($username){
    require_once "model/dbManager.php";

    if(isset(select('username', 'users', array('username' => $username))[0]['username'])){
        return 'Please, try another username, this one is already signed up.';
    }

    $result = check_text_length($username, 2, 32);
    if($result !== true){return $result;}

    return true;
}

/**
 * This function is designed to check text constraints.
 * @param $text : must be a string.
 * @param $min : must be minimum contained characters in $text string.
 * @param $max : must be maximum contained characters in $text string.
 * @return boolean : true or false.
 */
function check_text_length($text, $min, $max){
    if(strlen($text) < $min){return 'At least '. $min .' characters required.';}
    if(strlen($text) > $max){return 'Maximum of '. $max .' characters required.';}
    return true;
}

/**
 * This function is designed to check password constraints for sign_up action.
 * @param $password : must be a string.
 * @param $confirm : must be a string.
 * @return boolean : true or false.
 */
function check_password_constraints($password, $confirm){
    $minCharType = 0;

    $uppercase = false;
    $lowercase = false;
    $numeric = false;
    $special = false;

    // Check characters types contained in $password
    foreach(str_split($password) as $char){
        if(is_numeric($char)){$numeric = true;}
        if(ctype_upper($char)){$uppercase = true;}
        if(ctype_lower($char)){$lowercase = true;}
        if(preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $char)){$special = true;}
    }

    if($uppercase){$minCharType++;}
    if($lowercase){$minCharType++;}
    if($numeric){$minCharType++;}
    if($special){$minCharType++;}

    if(
        strlen($password) < 8 ||
        $minCharType < 3
    ){
        return 'Password requires at least 8 characters and 3 different types of characters.';
    }

    if($password !== $confirm){
        return 'Password and confirm must be the sames.';
    }

    return true;
}

/**
 * This function is designed to check POST values for sign_in action.
 * @param $request : must be POST form array.
 */
function sign_in_check($request){
    require_once "model/dbManager.php";

    global $errors;
    $errors['sign in'] = '';

    if(
        !empty($request['email']) &&
        !empty($request['password'])
    ){
        $email = $request['email'];
        $password = $request['password'];

        $check = true;

        if(!isset(select('email', 'users', array('email' => $email))[0]['email'])){$check = false;}

        if(
            $check &&
            password_verify($password, select('password', 'users', array('email' => $email))[0]['password'])
        ){
            try{
                createSession($request);
                $_SESSION['notify'] = 'You are signed in! Welcome back!';

                header('Location: index.php?action=home');
                die();
            }catch(Exception $e){
                $_SESSION['notify'] = 'An error has occurred. Please retry later.';
                sign_in();
            }
        }else{
            $errors['sign in'] = 'Username or password is wrong.';
            sign_in();
        }
    }else{
        sign_in();
    }
}

/**
 * This function is designed to check POST values for profile action.
 * @param $request : must be POST form array.
 */
function profile_check($request){
    require_once "model/dbManager.php";

    global $errors;
    $errors['description'] = '';
    $errors['import'] = '';

    // Description update
    if(!empty($request['description'])) {
        $data['description'] = $request['description'];
        try{
            update('users', $_SESSION['id'], $data);
            $_SESSION['notify'] = 'Your description has been updated.';
            profile();
        }catch(Exception $e){
            $_SESSION['notify'] = "An error occurred. Try again later please.";
            profile();
        }
    }

    // Profile image importation
    if (isset($_FILES['import'])) {
        $filename = $_SESSION['id'] .'pp';
        import_picture($_FILES['import'], $filename, 'view/content/picture/');
        $_SESSION['notify'] = "Your profile picture has been changed.";
    }

    // Friend request
    if (isset($request['friend_request'])) {
        if (empty(select('id', 'user_as_user', ['user1' => $_SESSION['id'], 'user2' => $_GET['id']]))) {
            $data['user1'] = $_SESSION['id'];
            $data['user2'] = $_GET['id'];
            $data['status'] = 0;
            insert('user_as_user', $data);
            $_SESSION['notify'] = "Your friend request has been sent.";
        }
        else
            $_SESSION['notify'] = "You already sent a friend request to this user.";
    }

    profile();
}

/**
 * This function is designed to check and insert POST values for article action.
 * @param $request : must be POST form array.
 */
function article_check($request){
    require_once "model/dbManager.php";

    // Insert|Update article user mark.
    if(!empty($request['mark'])){
        $data['mark'] = $request['mark'];
        $data['article'] = select('id', 'articles', ['ui' => $_GET['ui']])[0][0];
        $data['author'] = $_SESSION['id'];

        if (isset(select('id', 'mark_as_article', ['article' => $data['article'],'author' => $_SESSION['id']])[0][0])) {
            update('mark_as_article', select('id', 'mark_as_article', ['article' => $data['article'],'author' => $_SESSION['id']])[0][0], ['mark' => $data['mark']]);
        }
        else {
            insert('mark_as_article', $data);
        }
    }
    article();
}

/**
 * This function is designed to check and insert POST values for add_article action.
 * @param $request : must be POST form array.
 */
function add_article_check($request){
    require_once "model/dbManager.php";

    if(
        !empty($request['title']) ||
        isset($_FILES['import'])
    ){
        $data['ui'] = '';
        if (!empty($request['title'])){
            $data['ui'] = ui_generation('articles');
            $data['title'] = $request['title'];
            $data['releaseDate'] = $request['releaseDate'];
            $data['description'] = $request['description'];
            $data['artwork'] = select('id', 'artworks', ['ui' => $_GET['ui']])[0][0];
            $data['author'] = $_SESSION['id'];
            insert('articles', $data);
        }

        if (isset($_FILES['import'])) {
            $filename = $data['ui'];
            import_picture($_FILES['import'], $filename, 'view/content/picture/');
        }
        $_SESSION['notify'] = "Article added in database.";
        header('Location: index.php?action=article&ui='. $data['ui']);
        die();
    }
    add_article();
}

/**
 * This function is designed to check and insert POST values for add_artwork action.
 * @param $request : must be POST form array.
 */
function add_artwork_check($request){
    require_once "model/dbManager.php";

    if(
        !empty($request['title']) ||
        isset($_FILES['import'])
    ){
        $data['ui'] = '';
        if (!empty($request['title'])){
            $data['ui'] = ui_generation('articles');
            $data['title'] = $request['title'];
            $data['releaseDate'] = $request['releaseDate'];
            $data['description'] = $request['description'];
            $data['editor'] = $request['editor'];
            $data['type'] = $request['type'];
            insert('artworks', $data);
        }

        if (isset($_FILES['import'])) {
            $filename = $data['ui'];
            import_picture($_FILES['import'], $filename, 'view/content/picture/');
        }
        $_SESSION['notify'] = "Artwork added in database.";
        header('Location: index.php?action=description&ui='. $data['ui']);
        die();

    }
    add_artwork();
}

/**
 * This function is designed to generate unique identifiant (ui).
 * @param $table : must be the table name where the new data will be inserted.
 * @return string : generated ui.
 */
function ui_generation($table){
    $numeric = '1234567890';
    $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $lowercase = 'abcdefghijklmnopqrstuvwxyz';

    $ui = '';
    $valid = false;

    while(!$valid){
        while(strlen($ui) < 32){
            $charType = rand(1, 3);
            switch($charType){
                case 1: $ui .= $numeric[rand(0, strlen($numeric) -1)];
                break;
                case 2: $ui .= $uppercase[rand(0, strlen($uppercase) -1)];
                break;
                case 3: $ui .= $lowercase[rand(0, strlen($lowercase) -1)];
                break;
            }
        }

        // Check if ui is already registered in table.
        require_once "model/dbManager.php";
        if (!isset(select('ui', $table, ['ui' => $ui])[0][0])) {
            $valid = true;
        }
        else $ui = '';
    }
    return $ui;
}

/**
 * This function is designed to check pictures constraints.
 * @param $picture : must be imported $_FILE.
 * @param $filename : must be the picture name when imported in website folders.
 * @return string|boolean : filename|false.
 */
function picture_check($picture, $filename){
    if (!empty($picture)) {
        $type = $picture['type'];
        $allowed = true;
        switch($type){
            case 'image/png':
                $filename .= '.png';
            break;

            case 'image/jpg':
                $filename .= '.jpg';
            break;

            case 'image/jpeg':
                $filename .= '.jpeg';
            break;

            default:
                $allowed = false;
            break;
        }
    }
    if ($allowed) return $filename;
    return false;
}

/**
 * This function is designed to check and import pictures in website folders.
 * @param $newPicture : must be imported $_FILE.
 * @param $filename : must be the picture name when imported in website folders.
 * @param $url : must be folder url where picture will be saved.
 */
function import_picture($newPicture, $filename, $url){
    $pictureCheck = picture_check($newPicture, $filename);
    if($pictureCheck !== false){
        try{
            $allPictures = scandir($url);
            foreach($allPictures as $picture){
                $file = pathinfo($url. $picture);
                if($file['filename'] == $newPicture['name']){unlink($url . $file['basename']);}
            }
            move_uploaded_file($newPicture["tmp_name"], $url . $pictureCheck);
        }catch(Exception $e){
            $_SESSION['notify'] = "An error occurred, please try again later.";
        }
    }else $_SESSION['notify'] = "Allowed extensions: 'png', 'jpg', 'jpeg'.";
}

/**
 * This function is designed to check and update in DB from POST values for modify_artwork action.
 * @param $request : must be POST form array.
 */
function modify_artwork_check($request){
    require_once "model/dbManager.php";
    if (isset($request['submit'])){
        // Update values in DB
        update('artworks', select('id', 'artworks', ['ui' => $_GET['ui']])[0][0],
            [
                'title' => $request['title'],
                'releaseDate' => $request['releaseDate'],
                'type' => $request['type'],
                'editor' => $request['editor'],
                'description' => $request['description']
            ]
        );

        $_SESSION['notify'] = "Artwork has been modified.";
        header('Location: index.php?action=description&ui='. $_GET['ui']);
        die();
    }
    modify_artwork();
}

/**
 * This function is designed to check and update in DB from POST values for modify_article action.
 * @param $request : must be POST form array.
 */
function modify_article_check($request){
    require_once "model/dbManager.php";
    if (isset($request['submit'])){
        // Update values in DB
        update('articles', select('id', 'articles', ['ui' => $_GET['ui']])[0][0],
            [
                'title' => $request['title'],
                'releaseDate' => $request['releaseDate'],
                'description' => $request['description'],
                'artwork' => select('id', 'artworks', ['id' => select('artwork', 'articles', ['ui' => $_GET['ui']])[0][0]])[0][0],
                'author' => $_SESSION['id']
            ]
        );

        $_SESSION['notify'] = "Article has been modified.";
        header('Location: index.php?action=article&ui='. select('ui', 'articles', ['ui' => $_GET['ui']])[0][0]);
        die();
    }
    modify_article();
}

/**
 * This function is designed to remove article in DB.
 */
function remove_article(){
    require_once "model/dbManager.php";
    delete('mark_as_article', ['article' => select('id', 'articles', ['ui' => $_GET['ui']])[0][0]]);
    delete('articles', ['ui' => $_GET['ui']]);

    $_SESSION['notify'] = "Article has been removed.";
    header('Location: index.php?action=artwork');
    die();
}

/**
 * This function is designed to remove artwork in DB.
 */
function remove_artwork(){
    require_once "model/dbManager.php";
    delete('articles', ['artwork' => select('id', 'artworks', ['ui' => $_GET['ui']])[0][0]]);
    delete('artworks', ['ui' => $_GET['ui']]);

    $_SESSION['notify'] = "Artwork has been removed.";
    header('Location: index.php?action=artwork');
    die();
}

/**
 * This function is designed to update user relations to accept in DB.
 */
function accept_request() {
    require_once 'model/dbManager.php';
    if (!empty(select('id', 'user_as_user', ['user2' => $_SESSION['id'], 'user1' => $_GET['id']])))  update('user_as_user', select('id', 'user_as_user', ['user2' => $_SESSION['id'], 'user1' => $_GET['id']])[0][0], ['status' => 1]);
    header('Location: index.php?action=profile&id='. $_GET['id']);
    die();
}

/**
 * This function is designed to update user relations to reject in DB.
 */
function reject_request() {
    require_once 'model/dbManager.php';
    if (!empty(select('id', 'user_as_user', ['user2' => $_SESSION['id'], 'user1' => $_GET['id']])))  delete('user_as_user', ['user1' => $_GET['id'], 'user2' => $_SESSION['id']]);
    header('Location: index.php?action=profile&id='. $_GET['id']);
    die();
}

/**
 * This function is designed to remove artwork in DB.
 */
function remove_user() {
    require_once "model/dbManager.php";
    if (!empty(select('id, author', 'articles', ['author' => $_GET['id']]))) {
        $articles = select('id, author', 'articles', ['author' => $_GET['id']]);
        foreach ($articles as $article) update('articles', $article['id'], ['author' => $_SESSION['id']]);
    }

    delete('user_as_user', ['user1' => $_GET['id']]);
    delete('user_as_user', ['user2' => $_GET['id']]);
    delete('roles', ['user' => $_GET['id']]);
    delete('comment_as_article', ['author' => $_GET['id']]);
    delete('mark_as_article', ['author' => $_GET['id']]);
    delete('users', ['id' => $_GET['id']]);

    $_SESSION['notify'] = "User has been removed.";
    header('Location: index.php?action=users');
    die();
}

function add_category_check($request) {
    require_once "model/dbManager.php";
    if (isset($request['submit'])) {
        insert('categories', ['name' => $request['name']]);
        $_SESSION['notify'] = "Category has been added.";
    }

    header('Location: index.php?action=modify_categories');
    die();
}

function modify_category_check($request) {
    require_once "model/dbManager.php";
    update('categories', $_GET['id'], ['name' => $request['name']]);

    $_SESSION['notify'] = "Category has been modified.";
    header('Location: index.php?action=modify_categories');
    die();
}

function remove_category_check() {
    require_once "model/dbManager.php";
    delete('categories', ['id' => $_GET['id']]);

    $_SESSION['notify'] = "Category has been removed.";
    header('Location: index.php?action=modify_categories');
    die();
}