

// Load buildings
document.addEventListener("DOMContentLoaded", () => {
    loadBuildings();
});


// 🔹 Load Buildings
function loadBuildings() {
    fetch("/indoor_tracking/api/get_buildings.php")
        .then(res => res.json())
        .then(data => {
            let building = document.getElementById("building");

            data.forEach(b => {
                let option = document.createElement("option");
                option.value = b;
                option.text = b;
                building.appendChild(option);
            });
        });
}


// 🔹 Load Floors
function loadFloors() {
    let building = document.getElementById("building").value;

    let floor = document.getElementById("floor");
    let classBox = document.getElementById("class");

    floor.innerHTML = "<option value=''>All Floors</option>";
    classBox.innerHTML = "<option value=''>All Classes</option>";

    classBox.disabled = true;

    if (!building) {
        floor.disabled = true;
        return;
    }

    fetch(`/indoor_tracking/api/get_floors.php?building=${building}`)
        .then(res => res.json())
        .then(data => {

            floor.disabled = false;

            data.forEach(f => {
                let option = document.createElement("option");
                option.value = f;
                option.text = f;
                floor.appendChild(option);
            });
        });
}


// 🔹 Load Classes
function loadClasses() {
    let building = document.getElementById("building").value;
    let floor = document.getElementById("floor").value;

    let classBox = document.getElementById("class");
    classBox.innerHTML = "<option value=''>All Classes</option>";

    if (!floor) {
        classBox.disabled = true;
        return;
    }

    fetch(`/indoor_tracking/api/get_classes.php?building=${building}&floor=${floor}`)
        .then(res => res.json())
        .then(data => {

            classBox.disabled = false;

            data.forEach(c => {
                let option = document.createElement("option");
                option.value = c;
                option.text = c;
                classBox.appendChild(option);
            });
        });
}


// 🔹 Load Data
function loadData() {
    let building = document.getElementById("building").value;
    let floor = document.getElementById("floor").value;
    let className = document.getElementById("class").value;
    let search = document.getElementById("search")?.value || "";

    let url = `/indoor_tracking/fetch_data.php?building=${building}&floor=${floor}&class=${className}&search=${search}&live=${localStorage.getItem("liveMode")}`;

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