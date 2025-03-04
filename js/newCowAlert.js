document.addEventListener("DOMContentLoaded", function() {
    // Sikeres üzenet kezelése
    let successMessage = document.getElementById("success-message");
    if (successMessage) {
        successMessage.style.display = "flex";
        setTimeout(() => {
            successMessage.style.display = "none";
        }, 3000);
    }

    // Hibaüzenet kezelése
    let errorMessage = document.getElementById("error-message");
    if (errorMessage) {
        errorMessage.style.display = "flex";
        setTimeout(() => {
            errorMessage.style.display = "none";
        }, 3000);
    }
});