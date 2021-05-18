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
        $result = check_text_length($username, 2, 32);
        if($result != true){$errors['username'] = $result; $effective = false;}

        $email = $request['email'];
        $result = check_email($email);
        if($result != true){$errors['email'] = $result; $effective = false;}

        $password = $request['password'];
        $confirm = $request['confirm'];
        $result = check_password_constraints($password, $confirm);
        if($result != true){$errors['password'] = $result; $effective = false;}

        if($effective){
            $datas['username'] = $username;
            $datas['email'] = $email;
            $datas['password'] = password_hash($password, PASSWORD_DEFAULT);
            try{
                insert('users', $datas);
                notify('You are signed up! You can sign in now!');

                header('Location: index.php?action=sign_in');
                die();
            }catch(Exception $e){
                notify("An error occurred. Try again later please.");
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

    $requestResult = select('email', 'users', array('email' => $email))[0]['email'];
    if(isset($requestResult)){
        if($requestResult == $email){return 'Please, try another email, this one is already signed up.';}
    }
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

    if($password != $confirm){
        return 'Password and confirm must be the sames.';
    }

    return true;
}

function sign_in_check($request){
    require_once "model/dbManager.php";
    if(
        isset($request['email']) &&
        isset($request['password'])
    ){
        $check = true;

        // Init variables value from db datas
        $emailCheck = select('email', 'users', array('email' => $request['email']))[0]['email'];
        $hashCheck = select('password', 'users', array('email' => $request['email']))[0]['password'];


        if(!isset($emailCheck)){$check = false;}

        // Sign in check and init session values
        if(
            $check &&
            password_verify($request['password'], $hashCheck)
        ){
            try{
                createSession($request);
                $_SESSION['message'] = "You are signed in! Welcome back!";
                header('Location: index.php?action=home');
                die();
            }catch(Exception $e){
                $_SESSION['message'] = 'An error has occured. Please retry later.';
                sign_in();
            }
        }else{
            $message['general'] = 'Username or password is wrong.';
            sign_in();
        }
    }else{
        sign_in();
    }
}

function createSession($request){
    require_once "model/dbManager.php";
    $_SESSION['email'] = select('email', 'user', array('email' => $request['email']))[0]['email'];
}

/**
 * Init Sign out view
 */
function sign_out(){
    session_unset();
    session_destroy();
    home();
}