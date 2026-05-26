

// Load only when searching
function loadData() {

    let search = document.getElementById("search").value;

    if (!search) {
        document.getElementById("tableBody").innerHTML =
            "<tr><td colspan='7'>Search Student...</td></tr>";
        return;
    }

    let url = `/indoor_tracking/fetch_data.php?search=${encodeURIComponent(search)}&live=${localStorage.getItem("liveMode")}`;

    fetch(url)
        .then(res => res.json())
        .then(data => {

            document.getElementById("tableBody").innerHTML = data.rows;

            document.getElementById("deviceCountBox").innerHTML =
                "📊 Total Records: " + data.total;
        });
}

document.addEventListener("DOMContentLoaded", () => {
    let btn = document.getElementById("liveBtn");

    if (btn && liveMode) {
        btn.innerText = "🟢 Normal Mode";
        btn.classList.remove("live-off");
        btn.classList.add("live-on");
    }
});