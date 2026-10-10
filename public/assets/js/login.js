document.addEventListener("DOMContentLoaded", function () {

    const password = document.getElementById("password");
    const passwordToggle = document.getElementById("passwordToggle");
    const loginForm = document.getElementById("loginForm");


    // PASSWORD SHOW / HIDE
    if (password && passwordToggle) {

        passwordToggle.addEventListener("click", function () {

            const icon = this.querySelector("i");

            if (password.type === "password") {

                password.type = "text";

                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");

            } else {

                password.type = "password";

                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");

            }

        });

    }


    // LOGIN BUTTON LOADING
    if (loginForm) {
        loginForm.addEventListener("submit", function () {

            const loginButton =
                loginForm.querySelector(".login-btn");

            if (!loginButton) {
                return;
            }

            loginButton.disabled = true;

            loginButton.innerHTML = `
                <i class="fa-solid fa-circle-notch fa-spin"></i>
                <span>Signing In...</span>
            `;

        });
    }
});