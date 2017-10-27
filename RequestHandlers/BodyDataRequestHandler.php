<?php
require_once '/Library/WebServer/Documents/WorkoutBuddy_Scripts/DbOperations/DbOperation.php';

$response = array();

$user_id = $_GET['userId'];
$request_response = 'RequestResponse';

if(isset($_GET['request'])) {
    
    switch($_GET['request']) {
            
        case 'getBodyData':
            $db = new DbOperation();
            $response['error'] = false;
            $response['message'] = 'Request successfully completed';
            $response[$request_response] = $db->getBodyData();
            break;
    }
} else {
    $response['error'] = true; 
 $response['message'] = 'Invalid Request';
}

echo json_encode($response);
?>