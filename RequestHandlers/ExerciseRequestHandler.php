<?php
require_once '/Library/WebServer/Documents/WorkoutBuddy_Scripts/DbOperations/DbOperation.php';

$response = array();

$user_id = $_GET['userId'];
//$sub_workout_id = $_GET['subWorkoutId'];
$request_response = 'RequestResponse';

if(isset($_GET['request'])) {
    
    switch($_GET['request']) {
        case 'getDefaultExercises':
            $db = new DbOperation();
            $response['error'] = false;
            $response['message'] = 'Request successfully completed';
            $response[$request_response] = $db->getDefaultExercises();
            break;
        case 'getCustomExercises':
            $db = new DbOperation();
            $response['error'] = false;
            $response['message'] = 'Request successfully completed';
            $response[$request_response] = $db->getCustomExercises($user_id);
            break;
        case 'getAllExercises':
            $db = new DbOperation();
            $response['error'] = false;
            $response['message'] = 'Request successfully completed';
            $response[$request_response] = $db->getAllExercises($user_id);
            break;
    }
} else {
    $response['error'] = true; 
    $response['message'] = 'Invalid Request';
}
echo json_encode($response);
?>