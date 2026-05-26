<?php
include 'db.php';

$search = $_GET['search'] ?? '';

// ✅ DISTINCT CLASS DATA
$sql = "SELECT DISTINCT room AS class, building, floor 
        FROM device_history 
        WHERE room LIKE '%$search%'";

$result = mysqli_query($conn, $sql);

$output = "";
$count = mysqli_num_rows($result); // ✅ TOTAL

while ($row = mysqli_fetch_assoc($result)) {
    $output .= "<tr>
        <td>{$row['class']}</td>
        <td>{$row['building']}</td>
        <td>{$row['floor']}</td>
    </tr>";
}

echo json_encode([
    "html" => $output,
    "total" => $count
]);