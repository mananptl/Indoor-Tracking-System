<?php
include 'db.php';

// Get JSON data from request
$data = json_decode(file_get_contents("php://input"), true);

// Extract values
$device_id = $data['device_id'];
$node_id   = $data['node_id'];
$rssi      = $data['rssi'];

// Insert into database
$sql = "INSERT INTO device_logs (device_id, node_id, rssi)
        VALUES ('$device_id', '$node_id', '$rssi')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error"]);
}

// After inserting data, run location calculation
file_get_contents("http://localhost:8080/indoor_tracking/calculate_location.php");
?>