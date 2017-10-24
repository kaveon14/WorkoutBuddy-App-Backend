<?php
//add sub folders to better organize these files
require_once '/Library/WebServer/Documents/WorkoutBuddy_Scripts/DbOperation.php';

$response = array();

$user_id = $_GET['userId'];
$main_workout_id = $_GET['mainWorkoutId'];
$sub_workout_id = $_GET['subWorkoutId'];

if(isset($_GET['apicall'])) {

    switch($_GET['apicall']) {
        case 'getMainWorkoutNames':
            break;
        case 'getSubWorkoutNames':
            break;
    }
} else {

 $response['error'] = true; 
 $response['message'] = 'Invalid API Call';
}
  
echo json_encode($response);
?>

