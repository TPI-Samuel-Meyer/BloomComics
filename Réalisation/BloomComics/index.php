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

    /*
     *
     *  PAGES
     *
     */

    /*
     *
     *  FEATURES
     *
     */

    /* DEFAULT */
    default :
        home();
    break;
}
