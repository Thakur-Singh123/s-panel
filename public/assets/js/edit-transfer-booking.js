document.addEventListener("DOMContentLoaded", function () {

    const form =
        document.getElementById(
            "editTransferBookingForm"
        );


    if (!form) {
        return;
    }


    form.addEventListener(
        "submit",
        function (event) {

            /*
             * Demo only.
             *
             * Laravel developer should remove
             * event.preventDefault() when backend
             * action is connected.
             */

            event.preventDefault();


            const submitButton =
                form.querySelector(
                    ".edit-submit-btn"
                );


            if (!submitButton) {
                return;
            }


            const oldContent =
                submitButton.innerHTML;


            submitButton.disabled = true;


            submitButton.innerHTML = `
                <i class="fa-solid fa-circle-notch fa-spin"></i>
                Saving Changes...
            `;


            setTimeout(function () {

                submitButton.disabled = false;

                submitButton.innerHTML =
                    oldContent;

                alert(
                    "Demo: Booking changes saved successfully."
                );

            }, 900);

        }
    );

});