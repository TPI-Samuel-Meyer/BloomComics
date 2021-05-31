<?php
/*
 * User: Samuel Meyer
 * Date: 10.05.2021
 *
 */

// Session creation
session_start();

// DB connection
require_once 'model/dbConnector.php';
try{
    $db = new Db;
}catch (PDOException $exception) {
    echo 'Connection failed: ' . $exception->getMessage();
    die();
}

// Import all files contained in controller folder
$controllerFiles = glob( __DIR__ . '/controller/*.php');
foreach($controllerFiles as $file){require_once($file);}

// Do GET action
if(!isset($_GET['action'])){$_GET['action'] = 'home';}
switch ($_GET['action']) {

    case 'artwork' :
        artwork();
    break;

    case 'article' :
        article_check($_POST);
    break;

    case 'add_article' :
        add_article_check($_POST);
    break;

    case 'modify_article' :
        modify_article_check($_POST);
    break;

    case 'remove_article' :
        remove_article();
    break;

    case 'add_artwork' :
        add_artwork_check($_POST);
    break;

    case 'modify_artwork' :
        modify_artwork_check($_POST);
    break;

    case 'remove_artwork' :
        remove_artwork();
    break;

    case 'description' :
        description($_GET);
    break;

    case 'profile' :
        profile_check($_POST);
    break;

    case 'friends' :
        friends();
    break;

    case 'accept_request' :
        accept_request();
    break;

    case 'reject_request' :
        reject_request();
    break;

    case 'remove_user' :
        remove_user();
    break;

    case 'modify_categories' :
        modify_categories();
    break;

    case 'add_category' :
        add_category_check($_POST);
    break;

    case 'modify_category' :
        modify_category_check($_POST);
    break;

    case 'remove_category' :
        remove_category_check();
    break;

    case 'sign_in' :
        sign_in_check($_POST);
    break;

    case 'sign_out' :
        sign_out();
    break;

    case 'sign_up' :
        sign_up_check($_POST);
    break;

    case 'users' :
        users($_GET);
    break;

    default :
        home();
    break;
}
