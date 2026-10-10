document.addEventListener("DOMContentLoaded", function () {

    const toggle = document.getElementById("tlFilterToggle");
    const body = document.getElementById("tlFilterBody");

    if (toggle && body) {
        toggle.addEventListener("click", function () {
            body.classList.toggle("is-collapsed");

            const icon = toggle.querySelector("i");
            if (icon) {
                icon.classList.toggle("fa-chevron-up");
                icon.classList.toggle("fa-chevron-down");
            }
        });
    }

    const tours = Array.from(
        document.querySelectorAll(".tl-tour-item")
    );

    const getValue = (id) =>
        (document.getElementById(id)?.value || "").trim().toLowerCase();

    function filterTours() {
        const location = getValue("tourLocation");
        const status = getValue("tourStatus");
        const approval = getValue("approvalStatus");
        const productId = getValue("tourProductId");
        const name = getValue("tourName");
        const quick = getValue("quickTourSearch");

        let visible = 0;

        tours.forEach((tour) => {
            const title = tour.querySelector("h3")?.textContent.toLowerCase() || "";
            const id = tour.dataset.id || "";
            const searchable = (tour.textContent + " " + id).toLowerCase();

            const match =
                (!location || tour.dataset.location.toLowerCase() === location) &&
                (!status || tour.dataset.status === status) &&
                (!approval || tour.dataset.approval === approval) &&
                (!productId || id.includes(productId)) &&
                (!name || title.includes(name)) &&
                (!quick || searchable.includes(quick));

            tour.hidden = !match;

            if (match) visible++;
        });

        document.getElementById("tlShowingCount").textContent = visible;
        document.getElementById("tlEmptyState").hidden = visible > 0;
    }

    document.getElementById("applyTourFilter")
        ?.addEventListener("click", filterTours);

    document.getElementById("quickTourSearch")
        ?.addEventListener("input", filterTours);

    document.getElementById("resetTourFilter")
        ?.addEventListener("click", function () {
            [
                "tourLocation",
                "tourStatus",
                "approvalStatus",
                "tourProductId",
                "tourName",
                "quickTourSearch"
            ].forEach(id => {
                const field = document.getElementById(id);
                if (field) field.value = "";
            });

            filterTours();
        });

});