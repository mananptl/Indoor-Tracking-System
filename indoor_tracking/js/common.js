function filterByEnrollment(enrollment) {
    let search = document.getElementById("search");

    if (search) {
        search.value = enrollment;
    }

    if (typeof loadData === "function") {
        loadData();
    }
}