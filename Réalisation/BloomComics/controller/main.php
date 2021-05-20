<?php
/*
 * User: Samuel Meyer
 * Date: 11.02.2021
 * Updated by :
 * - 10.05.21 - Samuel Meyer
 *  Copy the file and remove the useful code for BloomComics project.
 *
 */

/**
 * This function is design to set the site title and import the page php file from action.
 * @param $page : must be the name of the page.
 * Important : $_GET action name must be the same as file.
 */
function page_constructor($page){
    ob_start();
    global $errors;
    require_once 'view/'. $_GET['action'] .'.php';

    $content = ob_get_clean();
    require_once "view/template.php";
}

/**
 * This function is design to construct the home page.
 */
function home(){
    page_constructor('Home');
}

/**
 * This function is design to construct the artwork page.
 */
function artwork(){
    page_constructor('Artwork');
}

/**
 * This function is design to construct the article page.
 */
function description($object){
    page_constructor('Description');
}

/**
 * This function is design to construct the sign in page.
 */
function sign_in(){
    page_constructor('Sign in');
}

/**
 * This function is design to construct the sign up page.
 */
function sign_up(){
    page_constructor('Sign up');
}

function createSession($request){
    require_once "model/dbManager.php";
    $_SESSION['username'] = select('username', 'users', array('email' => $request['email']))[0][0];
    if(isset(select('role', 'roles', array('user' => select('id', 'users', array('email' => $request['email']))[0][0]))[0][0])) {
        $_SESSION['type'] = select('role', 'roles', array('user' => select('id', 'users', array('email' => $request['email']))[0][0]))[0][0];
    }
}

/**
 * This function is design to destroy user session when sign out.
 */
function sign_out(){
    global $notify;
    $notify = 'You are signed out. Thank you for your visit and do not forget to come back!';

    session_unset();
    session_destroy();
    header('Location: index.php?action=home');
    die();
}

/**
 * This function is design to construct the profile page.
 */
function profile(){
    page_constructor('Profile');
}

/**
 * This function is design to display instant temporary notification.
 * @param $text : must be the contained text in notification.
 */
function notify($text){
    if(isset($text)){
        $time = strlen($text) * 75;
        $transition = 2;
        $total = $time + ($transition * 1000);

        echo "
      <div class='notification' id='notification'><div class='content'>". $text ."</div></div>
      <script>
        setInterval(
          function(){
            document.getElementById('notification').style.opacity = 0;
            document.getElementById('notification').style.transition = '". $transition ."s';
          }
        , ". $time .");
        setInterval(
          function(){
            document.getElementById('notification').style.display = 'none';
          }
        , ". $total .")
      </script>
    ";
        unset($text);
    }
}