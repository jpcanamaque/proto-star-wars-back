<?php 

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../objects/StarWars.php';

if($_SERVER['REQUEST_METHOD'] == 'GET') {
    $database = new Database();
    $db = $database->getConnection();
    $sw = new StarWars($db);
    $result = $sw->getMostVehiclePilot();
    
    if(!count($result)) {
        http_response_code(503);
        echo json_encode(array('message' => "No data found"));
    } else {
        echo json_encode($result);
    }
} else {
    http_response_code(405);
}