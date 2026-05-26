<?php
include 'db.php';

// 🔐 SAFE INPUTS
$search    = $conn->real_escape_string($_GET['search'] ?? '');
$device_id = $conn->real_escape_string($_GET['device_id'] ?? '');
$building  = $conn->real_escape_string($_GET['building'] ?? '');
$floor     = $conn->real_escape_string($_GET['floor'] ?? '');
$class     = $conn->real_escape_string($_GET['class'] ?? '');

$live = $_GET['live'] ?? 'false';

// 🟢 LIVE MODE → ONLY LATEST RECORD PER DEVICE
if ($live === 'true') {

    $sql = "
    SELECT 
        dh.device_id,
        d.enrollment_no,
        d.student_name,
        dh.room AS class_name,
        dh.floor,
        dh.building,
        dh.created_at
    FROM device_history dh
    LEFT JOIN devices d ON dh.device_id = d.device_id
    INNER JOIN (
        SELECT device_id, MAX(created_at) as latest
        FROM device_history
        GROUP BY device_id
    ) latest_data
    ON dh.device_id = latest_data.device_id 
    AND dh.created_at = latest_data.latest
    WHERE 1=1
    ";

} else {

    // 🔴 NORMAL MODE
    $sql = "
    SELECT 
        dh.device_id,
        d.enrollment_no,
        d.student_name,
        dh.room AS class_name,
        dh.floor,
        dh.building,
        dh.created_at
    FROM device_history dh
    LEFT JOIN devices d ON dh.device_id = d.device_id
    WHERE 1=1
    ";

    // 🔹 Data range logic
    if ($device_id != '') {

        $sql .= " AND dh.device_id = '$device_id'";
        $sql .= " AND DATE(dh.created_at) = CURDATE()";

    } elseif ($search != '' || $building != '' || $floor != '' || $class != '') {

        $sql .= " AND DATE(dh.created_at) = CURDATE()";

    } else {

        $sql .= " AND dh.created_at >= NOW() - INTERVAL 10 MINUTE";
    }
}


// 🔹 FILTERS (SAFE)

// Search
if ($search != '') {
    $sql .= " AND (
        d.student_name LIKE '%$search%' OR
        d.enrollment_no LIKE '%$search%' OR
        dh.device_id LIKE '%$search%'
    )";
}

// Building
if ($building != '') {
    $sql .= " AND dh.building = '$building'";
}

// Floor
if ($floor != '') {
    $sql .= " AND dh.floor = '$floor'";
}

// Class
if ($class != '') {
    $sql .= " AND dh.room = '$class'";
}

// 🔹 ORDER
$sql .= " ORDER BY dh.created_at DESC";

$result = $conn->query($sql);

// ❌ ERROR CHECK
if (!$result) {
    die("SQL Error: " . $conn->error);
}

$total = $result->num_rows;
$rows = "";

// ❌ No data
if ($total == 0) {
    $rows .= "<tr><td colspan='7'>No Data Found</td></tr>";
}

// ✅ Loop data
while($row = $result->fetch_assoc()) {
    $rows .= "<tr>
        <td>{$row['device_id']}</td>
        <td>
            <a href='#' onclick=\"filterByEnrollment('{$row['enrollment_no']}')\">
                {$row['enrollment_no']}
            </a>
        </td>
        <td>{$row['student_name']}</td>
        <td>{$row['class_name']}</td>
        <td>{$row['floor']}</td>
        <td>{$row['building']}</td>
        <td>{$row['created_at']}</td>
    </tr>";
}

// ✅ Return JSON
echo json_encode([
    "rows" => $rows,
    "total" => $total
]);
?>