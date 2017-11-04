<?php

$file_path = "/Users/kaveon14/WorkoutBuddy/WorkoutBuddySite/UserMedia/media/ProgressPhotos/";
     
    $file_path = $file_path.$_FILES['uploaded_file']['name'];
    if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $file_path) ){
        echo "success";
    } else{
        echo $file_path;
    }
?>