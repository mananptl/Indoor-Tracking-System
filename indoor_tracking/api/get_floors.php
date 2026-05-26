<?php
include('../db.php');

$building = $_GET['building'] ?? '';

$res = $conn->query("SELECT DISTINCT floor FROM nodes WHERE building='$building'");

$data = [];

while($row = $res->fetch_assoc()) {
    $data[] = $row['floor'];
}

echo json_encode($data);