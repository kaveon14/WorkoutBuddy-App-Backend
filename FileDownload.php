<?php

include_once("DbOperations/Constants.php");

$file_name = $_GET['file_name'];
$file = PROGRESS_PHOTO_PATH.$file_name;

if(file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($file).'"');
    header('Expires: 0');
    header('Pragma: public');
    header('Content-length: '.filesize($file));
    readfile($file);
    exit;
}
?>