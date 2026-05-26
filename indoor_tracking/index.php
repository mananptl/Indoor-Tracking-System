<?php include 'db.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Indoor Tracking Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<div class="container">

    <h2>📡 Indoor Tracking Dashboard</h2>

    <?php include 'header_ui.php'; ?>

    <input type="hidden" id="totalCount" value="0">

    <table>
        <thead>
            <tr>
                <th>Device</th>
                <th>Enrollment</th>
                <th>Student Name</th>
                <th>Class</th>
                <th>Floor</th>
                <th>Building</th>
                <th>Time</th>
            </tr>
        </thead>

        <tbody id="tableBody">
            <tr><td colspan="7">Loading...</td></tr>
        </tbody>
    </table>

</div>

<script src="js/common.js"></script>
<script src="js/main.js"></script>
<script src="js/live.js"></script>

</body>
</html>