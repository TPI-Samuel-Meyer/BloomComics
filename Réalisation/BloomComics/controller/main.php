<?php
/*
 * User: Samuel Meyer
 * Date: 11.02.2021
 * Updated by :
 * - 10.05.21 - Samuel Meyer
 *  Copy the file and remove the useful code for BloomComics project.
 */

/**
 * This function is design to set the site title and import the page php file from action.
 * @param $page : must be the name of the page.
 * Important : $_GET action name must be the same as file.
 */
function page_constructor($page){
    ob_start();
    global $errors;
    if(isset($_SESSION['notify'])){notify($_SESSION['notify']); unset($_SESSION['notify']);}
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
 * This function is design to construct the artwork page.
 */
function article(){
    page_constructor('Article');
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
    $_SESSION['id'] = select('id', 'users', array('email' => $request['email']))[0][0];
    if(isset(select('role', 'roles', array('user' => select('id', 'users', array('email' => $request['email']))[0][0]))[0][0])) {
        $_SESSION['type'] = select('role', 'roles', array('user' => select('id', 'users', array('email' => $request['email']))[0][0]))[0][0];
    }
}

/**
 * This function is design to destroy user session when sign out.
 */
function sign_out(){
    session_unset();
    session_destroy();
    $_SESSION['notify'] = 'You are signed out. Thank you for your visit and do not forget to come back!';
    $_GET['action'] = 'home';
    home();
}

/**
 * This function is design to construct the profile page.
 */
function profile(){
    page_constructor('Profile');
}

/**
 * This function is design to display instant temporary notification.
 * @param $text : must be contained text in notification.
 * @param $type : must be notification type (true:info|false:error).
 */
function notify($text, $type = true){
    if(isset($text)){
        $time = strlen($text) * 75;
        $transition = 2;
        $total = $time + ($transition * 1000);
    ?>
      <div class='notification<?php if (!$type) {echo '-error';}?>' id='notification'><span class='content'><?=$text;?></span></div>
      <script>
        setInterval(
          function(){
            document.getElementById('notification').style.opacity = 0;
            document.getElementById('notification').style.transition = '<?=$transition;?>s';
          }
        , <?=$time;?>);
        setInterval(
          function(){
            document.getElementById('notification').style.display = 'none';
          }
        , <?=$total;?>)
      </script>
    <?php
        unset($text);
    }
}

function users($object){
    page_constructor('Users');
}

/**
 * This function is design to construct the add_article page.
 */
function add_article()
{
    ob_start();
    global $errors;
    $page = 'Add article';
    if (isset($_SESSION['notify'])) {
        notify($_SESSION['notify']);
        unset($_SESSION['notify']);
    }
    $content = include 'view/form.php';

    $content = ob_get_clean();
    require_once "view/template.php";
}

/**
 * This function is design to construct the add_artwork page.
 */
function add_artwork(){
    ob_start();
    global $errors;
    $page = 'Add artwork';
    if(isset($_SESSION['notify'])){notify($_SESSION['notify']); unset($_SESSION['notify']);}
    $content = include 'view/form.php';

    $content = ob_get_clean();
    require_once "view/template.php";
}

/**
 * This function is design to construct the modify_artwork page.
 */
function modify_artwork(){
    ob_start();
    global $errors;
    $page = 'Modify artwork';
    if(isset($_SESSION['notify'])){notify($_SESSION['notify']); unset($_SESSION['notify']);}
    $content = include 'view/form.php';

    $content = ob_get_clean();
    require_once "view/template.php";
}

/**
 * This function is design to construct the modify_article page.
 */
function modify_article(){
    ob_start();
    global $errors;
    $page = 'Modify article';
    if(isset($_SESSION['notify'])){notify($_SESSION['notify']); unset($_SESSION['notify']);}
    $content = include 'view/form.php';

    $content = ob_get_clean();
    require_once "view/template.php";
}

function friends() {
    ob_start();
    global $errors;
    $page = 'Friends';
    if(isset($_SESSION['notify'])){notify($_SESSION['notify']); unset($_SESSION['notify']);}
    $content = include 'view/users.php';

    $content = ob_get_clean();
    require_once "view/template.php";
}