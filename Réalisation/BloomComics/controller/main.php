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