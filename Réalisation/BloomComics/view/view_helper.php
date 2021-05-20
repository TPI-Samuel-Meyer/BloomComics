<?php
/*
 * User: Samuel Meyer
 * Date: 20.05.2021
 */

function check_img($ui){
    $imgsrc = 'view/content/picture/'. $ui .'.jpg';
    if(!file_exists($imgsrc)){$imgsrc = 'view/content/picture/none.jpg';}
    return $imgsrc;
}