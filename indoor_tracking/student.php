<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Student View</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<div class="container">

    <h2>👨‍🎓 Student Tracking</h2>

    <?php include 'header_ui.php'; ?>

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
            <tr><td colspan="7">Search Student...</td></tr>
        </tbody>
    </table>

</div>

<script src="js/common.js"></script>
<script src="js/student.js"></script>
<script src="js/live.js"></script>
</body>
</html>