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
    var_dump($errors);
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

/**
 * This function is design to display instant notifications.
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