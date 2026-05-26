<?php
include '../db.php';

// ✅ Devices
$devices = ["D1","D2","D3","D4","D5","D6","D7","D8"];

// ✅ Nodes (MATCH YOUR DB)
$nodes = [
    "room116_1" => "116",
    "room116_2" => "116",
    "lab115_1"  => "115",
    "lab115_2"  => "115",
    "room218_1" => "218",
    "room218_2" => "218",
    "lobby1"    => "lobby"
];

// ✅ Movement map
$map = [
    "116" => ["lobby"],
    "115" => ["lobby"],
    "218" => ["lobby"],
    "lobby" => ["116", "115", "218"]
];

// ✅ Load state
$file = "device_state.json";

if (!file_exists($file)) {
    $state = [
        "D1"=>"116","D2"=>"116","D3"=>"lobby","D4"=>"115",
        "D5"=>"218","D6"=>"lobby","D7"=>"115","D8"=>"218"
    ];
    file_put_contents($file, json_encode($state));
} else {
    $state = json_decode(file_get_contents($file), true);
}

// ✅ Move devices
foreach ($state as $d => $room) {
    if (rand(1,100) < 40) {
        $next = $map[$room];
        $state[$d] = $next[array_rand($next)];
    }
}

file_put_contents($file, json_encode($state));

// ✅ Insert realistic data
foreach ($devices as $d) {

    $currentRoom = $state[$d];

    // 🔹 Get nodes of SAME room
    $sameRoomNodes = [];

    foreach ($nodes as $node_id => $room) {
        if ($room == $currentRoom) {
            $sameRoomNodes[] = $node_id;
        }
    }

    // 🔹 Send STRONG signals (2 nodes)
    foreach ($sameRoomNodes as $node_id) {

        $rssi = rand(-60, -70);

        $sql = "
        INSERT INTO device_logs (device_id, node_id, rssi, created_at)
        VALUES ('$d', '$node_id', '$rssi', NOW())
        ";

        $conn->query($sql);
    }

    // 🔹 OPTIONAL: weak signal from lobby
    if ($currentRoom != "lobby") {

        $rssi = rand(-85, -95);

        $sql = "
        INSERT INTO device_logs (device_id, node_id, rssi, created_at)
        VALUES ('$d', 'lobby1', '$rssi', NOW())
        ";

        $conn->query($sql);
    }
}

echo "✅ Realistic fake data inserted!";

// 🔥 Trigger location calculation after inserting logs
file_get_contents("http://localhost:8080/indoor_tracking/calculate_location.php");
?>