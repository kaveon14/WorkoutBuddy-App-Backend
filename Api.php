<?php
//split this class up
require_once '/Library/WebServer/Documents/WorkoutBuddy_Scripts/DbOperation.php';

function isTheseParametersAvailable($params) {//still not sure of prupose
    $available = true;
    $missingParams = "";
    
    foreach($params as $param) {
        if(!isset($_POST[$param]) || strlen($_POST[$param])<=0) {
            $available = false;
            $missingParams = $missingParams.", ".$param;
        }
    }
    
    if(!$available) {
        $response = array();
        $response['error'] = true;
        $response['message'] = 'Parameters '.substr($missingParams,1,strlen($missingParams)).' missing';
        
        echo json_encode($response);
        die();
    }
}

$response = array();

$user_id = $_GET['userId'];

$sub_workout_id = $_GET['subWorkoutId'];


if(isset($_GET['apicall'])) {

    switch($_GET['apicall']) {
            
        case 'getDefaultExercises'://exercise_name needs to be changed
            $db = new DbOperation();
            $response['error'] = false;
            $response['message'] = 'Request successfully completed';
            $response['exercise_name'] = $db->getDefaultExercises();
            break;
        case 'getCustomExercises':
            $db = new DbOperation();
            $response['error'] = false;
            $response['message'] = 'Request successfully completed';
            $response['exercise_name'] = $db->getCustomExercises($user_id);
            break;
        case 'getAllExercises':
            $db = new DbOperation();
            $response['error'] = false;
            $response['message'] = 'Request successfully completed';
            $response['exercise_name'] = $db->getAllExercises($user_id);
            break;
        case 'getSubWorkoutExercises':
            $db = new DbOperation();
            $response['error'] = false;
            $response['message'] = 'Request successfully completed';
            $response['exercise_name'] = $db->getSubWorkoutExercises($sub_workout_id);
            break;
        case 'getGoalExercises':
            $db = new DbOperation();
            $response['error'] = false;
            $response['message'] = 'Request successfully completed';
            $response['exercise_name'] = $db->getGoalExercises($sub_workout_id);
            break;
    }
    
} else {

 $response['error'] = true; 
 $response['message'] = 'Invalid API Call';
 }
 
 echo json_encode($response);
?>