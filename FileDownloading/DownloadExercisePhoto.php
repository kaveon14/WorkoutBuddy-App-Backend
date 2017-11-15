<?php

include_once(dirname(__FILE__, 2).'/DbOperations/Constants.php');

$user_id = $_GET['userId'];
$file_name = $_GET['file_name'];
$file = getExercisePhotoDirectory($user_id);

if(file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    readfile($file);
    exit;
}
?>
