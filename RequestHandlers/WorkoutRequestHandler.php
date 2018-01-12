<?php
//add sub folders to better organize these files
require_once '/Library/WebServer/Documents/WorkoutBuddy_Scripts/DbOperations/DbOperation.php';

$response = array();
$request_response = 'RequestResponse';

function setSuccessfulResponse() {
    $GLOBALS['response']['error'] = false;
    $GLOBALS['response']['message'] = 'Request successfully completed';
}

function setFailedResponse() {
    $GLOBALS['response']['error'] = true;
    $GLOBALS['response']['message'] = 'Invalid API Call, Check Your Spelling';
}

if(isset($_GET['request'])) {
    $request = $_GET['request'];
    if($request =='getMainWorkoutNames' && isset($_GET['userId'])) {
        $db = new DbOperation();
        setSuccessfulResponse();
        $response[$request_response] = $db->getMainWorkoutNames($_GET['userId']);
    } else if($request == 'getSubWorkoutNames' && isset($_GET['mainWorkoutId'])) {
        $db = new DbOperation();
        setSuccessfulResponse();
        $response[$request_response] = $db->getSubWorkoutNames($_GET['mainWorkoutId']);
    } else if($request =='getGoalExercises' && isset($_GET['subWorkoutId'])) {
        $db = new DbOperation();
        setSuccessfulResponse();
        $response[$request_response] = $db->getGoalExercises($_GET['subWorkoutId']);
    } else {
        setFailedResponse();
    }
} else {
    setFailedResponse();
}
echo json_encode($response);
?>

