<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Class Category</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<div class="container">

    <h2>🏫 Class Category</h2>

    <?php include 'header_ui.php'; ?>

    <div class="filter-bar">

        <div class="custom-select">
            <select id="building" onchange="loadFloors(); loadData();">
                <option value="">Select Building</option>
            </select>
        </div>

        <div class="custom-select">
            <select id="floor" onchange="loadClasses(); loadData();" disabled>
                <option value="">All Floors</option>
            </select>
        </div>

        <div class="custom-select">
            <select id="class" onchange="loadData()" disabled>
                <option value="">All Classes</option>
            </select>
        </div>

    </div>

    <table>
        <thead>
        <tr>
            <th>Device</th>
            <th>Enrollment</th>
            <th>Name</th>
            <th>Class</th>
            <th>Floor</th>
            <th>Building</th>
            <th>Time</th>
        </tr>
        </thead>

        <tbody id="tableBody">
            <tr><td colspan="7">Select Building First</td></tr>
        </tbody>
    </table>

</div>

<script src="js/common.js"></script>
<script src="js/class.js"></script>
<script src="js/live.js"></script>

</body>
</html>