<?php
//add sub folders to better organize these files
require_once '/Library/WebServer/Documents/WorkoutBuddy_Scripts/DbOperations/DbOperation.php';

$response = array();

$user_id = $_GET['userId'];
$main_workout_id = $_GET['mainWorkoutId'];
$sub_workout_id = $_GET['subWorkoutId'];
$request_response = 'RequestResponse';

if(isset($_GET['request'])) {

    switch($_GET['request']) {
        case 'getMainWorkoutNames':
            $db = new DbOperation();
            $response['error'] = false;
            $response['message'] = 'Request successfully completed';
            $response[$request_response] = $db->getMainWorkoutNames($user_id);
            break;
        case 'getSubWorkoutNames':
            $db = new DbOperation();
            $response['error'] = false;
            $response['message'] = 'Request successfully completed';
            $response[$request_response] = $db->getSubWorkoutNames($main_workout_id);
            break;
        case 'getGoalExercises':
            $db = new DbOperation();
            $response['error'] = false;
            $response['message'] = 'Request successfully completed';
            $response[$request_response] = $db->getGoalExercises($sub_workout_id);
            break;
    }
} else {

 $response['error'] = true; 
 $response['message'] = 'Invalid API Call';
}
  
echo json_encode($response);
?>

