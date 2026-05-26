<?php
include 'db.php';


/*
 FINAL LOGIC (LEVEL 3 - PROJECT READY)

 1. Take last 10 sec data
 2. Avg RSSI per node
 3. Map node → room
 4. Multi-node confirmation (same room)
 5. Fallback strongest node
 6. Stability check
 7. Movement path (Lobby rule)
*/

// 🧭 Building Map (EDIT THIS AS PER YOUR BUILDING)
$map = [
    "116" => ["lobby"],
    "115" => ["lobby"],
    "218" => ["lobby"],
    "lobby" => ["116", "115", "218"]
];

// Step 1: Get recent data
$sql = "
SELECT 
    device_id,
    node_id,
    AVG(rssi) as avg_rssi,
    COUNT(*) as sample_count
FROM device_logs
WHERE created_at >= NOW() - INTERVAL 10 SECOND
AND rssi > -95
GROUP BY device_id, node_id
";

$result = $conn->query($sql);

$devices = [];

// Step 2: Attach node → room
while ($row = $result->fetch_assoc()) {

    $nodeQ = "SELECT room, floor, building FROM nodes WHERE node_id='".$row['node_id']."'";
    $nodeR = $conn->query($nodeQ);
    $nodeData = $nodeR->fetch_assoc();

    if (!$nodeData) continue;

    $devices[$row['device_id']][] = [
        'node_id' => $row['node_id'],
        'room' => $nodeData['room'],
        'floor' => $nodeData['floor'],
        'building' => $nodeData['building'],
        'avg_rssi' => $row['avg_rssi'],
        'count' => $row['sample_count']
    ];
}

// Step 3: Process each device
foreach ($devices as $device_id => $nodes) {

    $rooms = [];

    // Group nodes by room
    foreach ($nodes as $n) {
        $room = $n['room'];

        if (!isset($rooms[$room])) {
            $rooms[$room] = [
                'nodes' => [],
                'avg_rssi' => 0,
                'count' => 0,
                'floor' => $n['floor'],
                'building' => $n['building']
            ];
        }

        $rooms[$room]['nodes'][] = $n;
        $rooms[$room]['avg_rssi'] += $n['avg_rssi'];
        $rooms[$room]['count'] += 1;
    }

    // Step 4: Multi-node decision
    $selectedRoom = null;
    $selectedData = null;

    foreach ($rooms as $room => $data) {
        if ($data['count'] >= 2) {
            $selectedRoom = $room;
            $selectedData = $data;
            $selectedData['node_id'] = $data['nodes'][0]['node_id'];
            break;
        }
    }

    // Step 5: Fallback strongest node
    if (!$selectedRoom) {

        usort($nodes, function($a, $b) {
            return $b['avg_rssi'] <=> $a['avg_rssi'];
        });

        $best = $nodes[0];

        // Ignore weak signal
        if ($best['avg_rssi'] < -85) continue;

        $selectedRoom = $best['room'];
        $selectedData = [
            'floor' => $best['floor'],
            'building' => $best['building'],
            'node_id' => $best['node_id'],
            'avg_rssi' => $best['avg_rssi']
        ];
    }

    // Step 6: Get previous location
    $prevQ = "SELECT room FROM device_location WHERE device_id='$device_id'";
    $prevR = $conn->query($prevQ);
    $prev = $prevR->fetch_assoc();

    if ($prev) {

        $prevRoom = $prev['room'];

        // 🔒 Stability check
        if ($prevRoom != $selectedRoom) {

            // Require stronger RSSI to change
            if (isset($best) && $best['avg_rssi'] < -80) {
                continue;
            }

            // 🧭 Movement rule (NO teleport)
            //if (!isset($map[$prevRoom]) || !in_array($selectedRoom, $map[$prevRoom])) {
              //  continue;
            //}

            // ⏱ Require confirmation (2 readings)
            // ✅ Safety check before using node_id
            if (!isset($selectedData['node_id'])) {
                continue;
            }

            $checkQ = "
            SELECT COUNT(*) as cnt 
            FROM device_logs 
            WHERE device_id='$device_id'
            AND node_id='".$selectedData['node_id']."'
            AND created_at >= NOW() - INTERVAL 5 SECOND
            ";

            $checkR = $conn->query($checkQ);
            $check = $checkR->fetch_assoc();

            if ($check['cnt'] < 1) { // 🔥 changed from 2 → 1
                continue;
            }
        }
    }

    // Step 7: Save final location
    $update = "
    INSERT INTO device_location (device_id, room, floor, building)
    VALUES ('$device_id', '$selectedRoom', '".$selectedData['floor']."', '".$selectedData['building']."')
    ON DUPLICATE KEY UPDATE
    room='$selectedRoom',
    floor='".$selectedData['floor']."',
    building='".$selectedData['building']."',
    updated_at = CURRENT_TIMESTAMP
    ";

// Get previous room BEFORE update
$prevRoom = null;

$prevQ = "SELECT room FROM device_location WHERE device_id='$device_id'";
$prevR = $conn->query($prevQ);
$prevData = $prevR->fetch_assoc();

if ($prevData) {
    $prevRoom = $prevData['room'];
}

// Update current location
$conn->query($update);

// ✅ Insert into history ONLY if room changed
if ($prevRoom != $selectedRoom) {

    $history = "
    INSERT INTO device_history (device_id, room, floor, building)
    VALUES ('$device_id', '$selectedRoom', '".$selectedData['floor']."', '".$selectedData['building']."')
    ";

    $conn->query($history);
}
}

echo "🚀 Smart Tracking Active (Level 3)";


?>