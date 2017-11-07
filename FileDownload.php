<?php

include_once("DbOperations/Constants.php");

$file_name = $_GET['file_name'];
$file = PROGRESS_PHOTO_PATH.$file_name;

if(file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    readfile($file);
    exit;
}
?>