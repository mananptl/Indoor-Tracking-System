<?php
include '../db.php';

/*
📦 FILE BACKUP SYSTEM

1. Fetch old data (1 day or more)
2. Save as JSON file
3. Keep safe backup locally
*/

// 🔹 Get yesterday's data
$sql = "
SELECT * FROM device_history
WHERE DATE(created_at) = CURDATE() - INTERVAL 1 DAY
";

$result = $conn->query($sql);

$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// 🔹 Create backup folder if not exists
$folder = "files";

if (!file_exists($folder)) {
    mkdir($folder, 0777, true);
}

// 🔹 File name (date-based)
$fileName = $folder . "/backup_" . date("Y-m-d") . ".json";

// 🔹 Save JSON
file_put_contents($fileName, json_encode($data, JSON_PRETTY_PRINT));

echo "✅ Backup saved to file: " . $fileName;
?>