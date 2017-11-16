<?php

define('DB_HOST','127.0.0.1');//may be wrong
define('DB_USER','kaveon14');    
define('DB_PASS','playstation31');
define('DB_NAME','WorkoutBuddy_database');
define('PROGRESS_PHOTO_PATH_1','/Users/kaveon14/WorkoutBuddy/WorkoutBuddySite/UserMedia/media/user_');//these neeed better names
define('PROGRESS_PHOTO_PATH_2','/ProgressPhotos/');//possibly create a function for them instead

function getProgressPhotoDirectory($user_id) {
    if(empty($user_id)) {
        return '';
    }
    return '/Users/kaveon14/WorkoutBuddy/WorkoutBuddySite/UserMedia/media/user_'.$user_id.'/ProgressPhotos/';
}

function getExercisePhotoDirectory($user_id) {
    if(empty($user_id)) {
        return '';
    }
    return '/Users/kaveon14/WorkoutBuddy/WorkoutBuddySite/UserMedia/media/user_'.$user_id.'/CustomExerciseImages/';
}
?>