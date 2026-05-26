<?php
include('../db.php');

$res = $conn->query("SELECT DISTINCT building FROM nodes");

$data = [];

while($row = $res->fetch_assoc()) {
    $data[] = $row['building'];
}

echo json_encode($data);