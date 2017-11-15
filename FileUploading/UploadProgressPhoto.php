<?php

include_once(dirname(__FILE__, 2).'/SiteConstants.php');
require_once '/Library/WebServer/Documents/WorkoutBuddy_Scripts/DbOperations/DbOperation.php';

$user_id = $_POST['userId'];
$date_time = $_POST['date_time'];
$local_path = $_POST['local_path'];

$file_name = $_POST['file_name'];
if(!empty($file_name)) {
    $site_path = SITE_PP_PATH.$file_name;
    $db = new DbOperation();
    $db->saveProgressPhoto($user_id,$site_path,$date_time,$local_path);
}

$file_path = "/Users/kaveon14/WorkoutBuddy/WorkoutBuddySite/UserMedia/media/ProgressPhotos/";

    $file_path = $file_path.$_FILES['uploaded_file']['name'];
    if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $file_path) ){
        echo "File Uploaded";
    } else {
        echo 'File DID NOT Upload!!';
    }

?>9