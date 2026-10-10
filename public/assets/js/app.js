document.addEventListener("DOMContentLoaded", function () {

    const sidebar =
        document.getElementById("sidebar");

    const sidebarOpen =
        document.getElementById("sidebarOpen");

    const sidebarClose =
        document.getElementById("sidebarClose");

    const sidebarOverlay =
        document.getElementById("sidebarOverlay");


    function openSidebar() {

        if (!sidebar) {
            return;
        }

        sidebar.classList.add("open");

        if (sidebarOverlay) {
            sidebarOverlay.classList.add("show");
        }

        document.body.style.overflow = "hidden";
    }


    function closeSidebar() {

        if (!sidebar) {
            return;
        }

        sidebar.classList.remove("open");

        if (sidebarOverlay) {
            sidebarOverlay.classList.remove("show");
        }

        document.body.style.overflow = "";
    }


    if (sidebarOpen) {
        sidebarOpen.addEventListener(
            "click",
            openSidebar
        );
    }


    if (sidebarClose) {
        sidebarClose.addEventListener(
            "click",
            closeSidebar
        );
    }


    if (sidebarOverlay) {
        sidebarOverlay.addEventListener(
            "click",
            closeSidebar
        );
    }


    window.addEventListener(
        "resize",
        function () {

            if (window.innerWidth > 900) {

                if (sidebar) {
                    sidebar.classList.remove("open");
                }

                if (sidebarOverlay) {
                    sidebarOverlay.classList.remove("show");
                }

                document.body.style.overflow = "";
            }

        }
    );

});

document.addEventListener("DOMContentLoaded", function () {

    /* =========================================
       SIDEBAR MOBILE
    ========================================= */

    const sidebar =
        document.getElementById("sidebar");

    const sidebarOpen =
        document.getElementById("sidebarOpen");

    const sidebarClose =
        document.getElementById("sidebarClose");

    const sidebarOverlay =
        document.getElementById("sidebarOverlay");


    function openSidebar() {

        if (!sidebar) return;

        sidebar.classList.add("open");

        if (sidebarOverlay) {
            sidebarOverlay.classList.add("show");
        }

        document.body.style.overflow = "hidden";
    }


    function closeSidebar() {

        if (!sidebar) return;

        sidebar.classList.remove("open");

        if (sidebarOverlay) {
            sidebarOverlay.classList.remove("show");
        }

        document.body.style.overflow = "";
    }


    if (sidebarOpen) {
        sidebarOpen.addEventListener("click", openSidebar);
    }

    if (sidebarClose) {
        sidebarClose.addEventListener("click", closeSidebar);
    }

    if (sidebarOverlay) {
        sidebarOverlay.addEventListener("click", closeSidebar);
    }


    /* =========================================
       SIDEBAR DROPDOWNS
    ========================================= */

    const dropdownButtons =
        document.querySelectorAll(
            ".sidebar-dropdown .dropdown-toggle"
        );


    dropdownButtons.forEach(function (button) {

        button.addEventListener("click", function () {

            const parent =
                this.closest(".sidebar-dropdown");


            /*
             * Close other dropdowns
             */

            document
                .querySelectorAll(".sidebar-dropdown")
                .forEach(function (dropdown) {

                    if (dropdown !== parent) {
                        dropdown.classList.remove("open");
                    }

                });


            /*
             * Toggle clicked dropdown
             */

            parent.classList.toggle("open");

        });

    });


    /* =========================================
       KEEP MENU OPEN IF SUBMENU ACTIVE
    ========================================= */

    document
        .querySelectorAll(".submenu-item.active")
        .forEach(function (activeItem) {

            const parent =
                activeItem.closest(".sidebar-dropdown");

            if (parent) {
                parent.classList.add("open");
            }

        });


    /* =========================================
       RESPONSIVE
    ========================================= */

    window.addEventListener("resize", function () {

        if (window.innerWidth > 900) {

            if (sidebar) {
                sidebar.classList.remove("open");
            }

            if (sidebarOverlay) {
                sidebarOverlay.classList.remove("show");
            }

            document.body.style.overflow = "";

        }

    });

});