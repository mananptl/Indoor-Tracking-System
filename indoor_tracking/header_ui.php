<div class="top-bar">

    <!-- Search -->
    <div class="search-wrapper">
        <input type="text" id="search" onkeyup="loadData()" required>
        <label>SEARCH</label>
    </div>

    <!-- Navigation -->
    <div class="nav-links">
        <span onclick="window.location.href='index.php'">Home</span>
        <span onclick="window.location.href='class.php'">Class</span>
        <span onclick="window.location.href='student.php'">Student</span>
    </div>

    <!-- Live Button -->
    <button onclick="toggleLive()" id="liveBtn" class="live-off">
        Live Mode
    </button>

</div>

<!-- Count -->
<div id="deviceCountBox">
    📊 Total Records: 0
</div>