<?php

include_once(dirname(__FILE__, 2).'/DbOperations/Constants.php');

if(isset($_GET['userId']) && isset($_GET['file_name'])) {

    $file = getProgressPhotoDirectory($_GET['userId']).$_GET['file_name'];

    if(file_exists($file)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        $im = imagecreatefrompng($file);
        imagepng($im);
        exit;
    } else {
        echo 'File not found!!';
    }
} else {
    echo 'Some type of error message!!!';
}
?>http://localhost/WorkoutBuddy_Scripts/FileDownloading/DownloadProgressPhoto.php?userId=1&file_name=007-gym.png