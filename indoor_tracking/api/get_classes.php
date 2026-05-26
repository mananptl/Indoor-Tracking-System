<?php
include('../db.php');

$building = $_GET['building'] ?? '';
$floor = $_GET['floor'] ?? '';

$res = $conn->query("SELECT DISTINCT room FROM nodes WHERE building='$building' AND floor='$floor'");

$data = [];

while($row = $res->fetch_assoc()) {
    $data[] = $row['room'];
}

echo json_encode($data);