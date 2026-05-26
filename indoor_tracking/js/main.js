// 🔹 Load table data
function loadData() {

    let search = document.getElementById("search").value;

    let url = "fetch_data.php?search=" + encodeURIComponent(search) + "&live=" + liveMode;

    fetch(url)
        .then(res => res.json())
        .then(data => {

            document.getElementById("tableBody").innerHTML = data.rows;

            document.getElementById("deviceCountBox").innerHTML =
                "📊 Total Records: " + data.total;

        })
        .catch(err => {
            console.error("Fetch Error:", err);
        });
}


// 🔹 Initial load only (NO AUTO REFRESH HERE)
document.addEventListener("DOMContentLoaded", function () {
    loadData();
});


// 🔹 View history (by device)
function viewHistory(deviceId) {

    fetch("fetch_data.php?device_id=" + deviceId + "&live=" + liveMode)
        .then(res => res.json())
        .then(data => {

            document.getElementById("tableBody").innerHTML = data.rows;

            document.getElementById("deviceCountBox").innerHTML =
                "📊 Total Records: " + data.total;

        });
}


// 🔹 Reset to home
function goHome() {
    document.getElementById("search").value = "";
    loadData();
}