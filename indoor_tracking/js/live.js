// 🔥 GLOBAL LIVE MODE
let liveMode = localStorage.getItem("liveMode") === "true";

// Toggle button
function toggleLive() {
    liveMode = !liveMode;

    localStorage.setItem("liveMode", liveMode);

    updateLiveButton();

    if (typeof loadData === "function") {
        loadData();
    }
}

// Update button UI
function updateLiveButton() {
    let btn = document.getElementById("liveBtn");
    if (!btn) return;

    if (liveMode) {
        btn.innerText = "Normal Mode";
        btn.classList.remove("live-off");
        btn.classList.add("live-on");
    } else {
        btn.innerText = "Live Mode";
        btn.classList.remove("live-on");
        btn.classList.add("live-off");
    }
}

// Sync on page load
document.addEventListener("DOMContentLoaded", updateLiveButton);

// 🔥 AUTO LIVE REFRESH
setInterval(() => {

    if (!liveMode) return;

    if (typeof loadData === "function") {
        loadData();
    }

}, 1000);