<?php
require_once dirname(__FILE__).'/DbConnect.php';

$connection = new DbConnect();
$con = $connection->connect();
$username = $_GET['username'];

$result = $con->prepare("select id from auth_user where username='$username' ");
$result->execute();
$result->bind_result($test);

$id = array();

while($result->fetch()) {
    $z = array();
    $z['id'] = $test;
    array_push($id,$z);
}
$response = array();
$id = array_filter($id);

if(!empty($id)) {
    $response['error'] = false;
    $response['message'] = 'No error!';
    $response['id'] = $id;
} else {
    $response['error'] = true;
    $response['message'] = 'Wrong username';
}
 
echo json_encode($response);

?>