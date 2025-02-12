document.addEventListener("DOMContentLoaded", function() {
    let successMessage = document.getElementById("success-message");
    if (successMessage) {
        successMessage.style.display = "flex"; // Megjelenítés
        setTimeout(() => {
            successMessage.style.display = "none";
        }, 3000);
    }
});