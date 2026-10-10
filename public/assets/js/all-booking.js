/* ==========================================
   ALL BOOKING PAGE
========================================== */

document.addEventListener("DOMContentLoaded", function () {

    const bookingSearch =
        document.getElementById("bookingSearch");

    const bookingCards =
        document.querySelectorAll(".booking-card");


    /* SEARCH */
    if (bookingSearch) {

        bookingSearch.addEventListener(
            "input",
            function () {

                const keyword =
                    this.value
                        .toLowerCase()
                        .trim();


                bookingCards.forEach(
                    function (card) {

                        const searchData =
                            (
                                card.dataset.search ||
                                card.innerText
                            )
                            .toLowerCase();


                        if (
                            searchData.includes(keyword)
                        ) {

                            card.style.display = "";

                        } else {

                            card.style.display = "none";

                        }

                    }
                );

            }
        );

    }


    /* FILTER COLLAPSE MOBILE */

    const filterToggle =
        document.getElementById(
            "filterToggle"
        );

    const filterBody =
        document.getElementById(
            "bookingFilterBody"
        );


    if (
        filterToggle &&
        filterBody
    ) {

        filterToggle.addEventListener(
            "click",
            function () {

                filterBody.classList.toggle(
                    "mobile-hidden"
                );

            }
        );

    }


    /* RESET FILTER */

    const resetButton =
        document.getElementById(
            "resetBookingFilter"
        );


    if (resetButton) {

        resetButton.addEventListener(
            "click",
            function () {

                const startDate =
                    document.getElementById(
                        "startDate"
                    );

                const endDate =
                    document.getElementById(
                        "endDate"
                    );

                const type =
                    document.getElementById(
                        "bookingType"
                    );

                const status =
                    document.getElementById(
                        "bookingStatus"
                    );


                if (startDate) {
                    startDate.value = "";
                }

                if (endDate) {
                    endDate.value = "";
                }

                if (type) {
                    type.value = "";
                }

                if (status) {
                    status.value = "";
                }

            }
        );

    }

});

document.addEventListener("DOMContentLoaded", function () {

    const bookingIdInput = document.getElementById("bookingId");
    const bookingCards = document.querySelectorAll(".booking-card");

    if (bookingIdInput) {

        bookingIdInput.addEventListener("input", function () {

            const bookingId = this.value.toLowerCase().trim();

            bookingCards.forEach(function (card) {

                const cardText = card.innerText.toLowerCase();

                if (bookingId === "" || cardText.includes(bookingId)) {
                    card.style.display = "";
                } else {
                    card.style.display = "none";
                }

            });

        });

    }

});