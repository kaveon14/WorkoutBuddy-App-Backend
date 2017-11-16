<?php

include_once(dirname(__FILE__, 2).'/DbOperations/Constants.php');

if(isset($_GET['userId']) && isset($_GET['file_name'])) {

    $file = getExercisePhotoDirectory($_GET['userId']).$_GET['file_name'];
    if(file_exists($file)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        $im = imagecreatefrompng($file);
        imagepng($im);
    } else {
        echo 'File not found!!';
    }
} else {
    echo 'Some type of error message!!!';
}
?>
