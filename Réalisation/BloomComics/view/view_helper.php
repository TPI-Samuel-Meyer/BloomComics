<?php
/*
 * User: Samuel Meyer
 * Date: 20.05.2021
 */

/**
 * This function is designed to find an image in website folders from filename.
 * @param $name : must be the filename without extension.
 * @return string : returned image fullname.
 **/
function check_img($name){
    $allPictures = scandir('view/content/picture/');
    $alreadyHave = false;
    foreach($allPictures as $picture){
        $file = pathinfo('view/content/picture/'. $picture);
        if($file['filename'] == $name){
            $imgsrc = 'view/content/picture/'. $name .'.'. $file['extension'];
            $alreadyHave = true;
        }
    }
    if(!$alreadyHave){$imgsrc = 'view/content/picture/none.jpg';}
    return $imgsrc;
}