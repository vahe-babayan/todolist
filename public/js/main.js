if (document.body.classList.contains("page-index")) {
    let sort_by = document.querySelector(".sort-by");
    let sort_by_order = document.querySelector(".sort-by-order");

    sort_by.addEventListener("change", function () {
        makeSort(sort_by.value, sort_by_order.value);
    });
    sort_by_order.addEventListener("change", function () {
        makeSort(sort_by.value, sort_by_order.value);
    });
}

function makeSort (sort_by, sort_by_order) {
    let params_str = "sort_by=" + sort_by + "&sort_by_order=" + sort_by_order;

    location.search = location.search.replace(/&?sort_by=(.*)&sort_by_order=(.*)/, "") + (location.search.includes("?") ? "&" + params_str : "?" + params_str);
}
