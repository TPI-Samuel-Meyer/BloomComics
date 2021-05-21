<?php
/*
 * User: Samuel Meyer
 * Date: 18.05.20121
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

        $username = $request['username'];
        $result = check_username($username);
        if($result !== true){$errors['username'] = $result; $effective = false;}

        $email = $request['email'];
        $result = check_email($email);
        if($result !== true){$errors['email'] = $result; $effective = false;}

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

function check_email($email){
    require_once "model/dbManager.php";

    if(isset(select('email', 'users', array('email' => $email))[0]['email'])){
        return 'Please, try another email, this one is already signed up.';
    }
    return true;
}

function check_username($username){
    require_once "model/dbManager.php";

    if(isset(select('username', 'users', array('username' => $username))[0]['username'])){
        return 'Please, try another username, this one is already signed up.';
    }

    $result = check_text_length($username, 2, 32);
    if($result !== true){return $result;}

    return true;
}

function check_text_length($text, $min, $max){
    if(strlen($text) < $min){return 'At least '. $min .' characters required.';}
    if(strlen($text) > $max){return 'Maximum of '. $max .' characters required.';}
    return true;
}

function check_password_constraints($password, $confirm){
    $minCharType = 0;

    $uppercase = false;
    $lowercase = false;
    $numeric = false;
    $special = false;

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

function profile_check($request){
    require_once "model/dbManager.php";

    global $errors;
    $errors['description'] = '';
    $errors['import'] = '';

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
    }elseif(!empty($_FILES['import'])){
        $type = $_FILES['import']['type'];
        $name = $_SESSION['id'] .'pp';
        $allowed = false;
        switch($type){
            case 'image/png':
                $name .= '.png';
                $allowed = true;
            break;

            case 'image/jpg':
                $name .= '.jpg';
                $allowed = true;
            break;

            case 'image/jpeg':
                $name .= '.jpeg';
                $allowed = true;
            break;

            default:
                $allowed = false;
            break;
        }

        if($allowed){
            $url = 'view/content/picture/';
            try{
                $allPictures = scandir($url);
                foreach($allPictures as $picture){
                    $file = pathinfo($url. $picture);
                    if($picture == $name){unlink($url . $file['basename']);}
                }
                move_uploaded_file($_FILES["import"]["tmp_name"], $url . $name);
                profile();
            }catch(Exception $e){
                $_SESSION['notify'] = "An error occurred, please try again later.";
                profile();
            }
        }else{
            $_SESSION['notify'] = "Allowed extensions: 'png', 'jpg', 'jpeg'.";
            profile();
        }
    }else{
        profile();
    }
}

function article_check($request){
    require_once "model/dbManager.php";

    if(!empty($request['mark'])){
        $data['mark'] = $request['mark'];
        $data['article'] = select('id', 'article', array('ui' => $_GET['ui']))[0][0];
        $data['author'] = $_SESSION['id'];
        insert('mark_as_article', $data);
    }else{
        article();
    }
}