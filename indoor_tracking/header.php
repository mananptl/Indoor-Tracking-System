<div style="display:flex; align-items:center; gap:15px; margin-bottom:10px;">

    <!-- Search -->
    <input type="text" id="search" placeholder="Search..." onkeyup="loadData()">

    <!-- Navigation -->
    <span onclick="window.location.href='index.php'" style="cursor:pointer;">
        Home
    </span>

    <span onclick="window.location.href='class.php'" style="cursor:pointer; margin-left:10px;">
        Class
    </span>

    <span onclick="window.location.href='student.php'" style="cursor:pointer; margin-left:10px;">
        Student
    </span>



</div>

<!-- Total count -->
<div id="deviceCountBox">
    📊 Total Records: 0
</div>