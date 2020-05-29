<?php


$filenamevar =  $_GET["img"];
$filextenstionvar = substr($filenamevar, strpos($filenamevar, '.') + 1)  ;
if($filextenstionvar == "jpg" || $filextenstionvar == "jpeg")
{
    $img_r = imagecreatefromjpeg($_GET['img']);
    $dst_r = ImageCreateTrueColor( $_GET['w'], $_GET['h'] );

    imagecopyresampled($dst_r, $img_r, 0, 0, $_GET['x'], $_GET['y'], $_GET['w'], $_GET['h'], $_GET['w'],$_GET['h']);
    header('Content-type: image/jpeg');
    imagejpeg($dst_r);
    // Free up memory
    imagedestroy($img_r);
    imagedestroy($dst_r);

}

elseif($filextenstionvar == "png")
{
    $img_r = imagecreatefrompng($_GET['img']);
    $dst_r = ImageCreateTrueColor( $_GET['w'], $_GET['h'] ); 

    imagesavealpha( $dst_r, true );
    
    $trans_colour = imagecolorallocatealpha($dst_r, 0, 0, 0, 127);
    imagefill($dst_r, 0, 0, $trans_colour);

    imagecopyresampled($dst_r, $img_r, 0, 0, $_GET['x'], $_GET['y'], $_GET['w'], $_GET['h'], $_GET['w'],$_GET['h']);
    header('Content-type: image/png'); 
    imagepng($dst_r);
    // Free up memory
    imagedestroy($img_r);
    imagedestroy($dst_r);

}

    

    exit;
?>