console.log("Delete script loaded"); 
document.addEventListener("DOMContentLoaded", () => {
    const deleteLinks = document.querySelectorAll("a[href*='delete_cow.php']");
    const confirmOverlay = document.getElementById("confirmOverlay");
    const confirmYes = document.getElementById("confirmYes");
    const confirmNo = document.getElementById("confirmNo");

    let currentRow = null;
    let currentCowId = null;

    deleteLinks.forEach(link => {
        link.addEventListener("click", (event) => {
            event.preventDefault(); // Megakadályozzuk az alapértelmezett navigációt
            currentCowId = new URL(link.href).searchParams.get("id"); // ID kinyerése a linkből
            currentRow = link.closest("tr"); // A törlendő sor eltárolása
            confirmOverlay.style.display = "flex"; // Megjelenítjük a megerősítő ablakot
        });
    });

    confirmYes.addEventListener("click", () => {
        if (currentCowId && currentRow) {
            confirmOverlay.style.display = "none"; // Elrejtjük a megerősítő ablakot
            // AJAX kérés küldése a törléshez
            fetch(`delete_cow.php?id=${currentCowId}`, {
                method: "GET",
            })
            .then(response => response.text())
            .then(data => {
                if (data.trim() === "success") {
                    currentRow.remove(); // Sor törlése a táblázatból
                    Swal.fire({
                        title: "Törölve!",
                        text: "A tehén adatai törlésre kerültek.",
                        icon: "success",
                        confirmButtonText: "OK",
                            customClass: {
                                confirmButton: "btn btn-success" // Zöld gomb is
                            }
                    });
                } else {
                    Swal.fire({
                        title: "Hiba!",
                        text: "Nem sikerült törölni az elemet.",
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                }
            })
            .catch(error => {
                console.error("Hiba történt:", error);
                Swal.fire({
                    title: "Hiba!",
                    text: "Hálózati hiba történt.",
                    icon: "error",
                    confirmButtonText: "OK"
                });
            });
        }
    });

    confirmNo.addEventListener("click", () => {
        confirmOverlay.style.display = "none"; // Elrejtjük a megerősítő ablakot
    });

    // Törlés gombok kezelése
    document.querySelectorAll('.deleteButton').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const deleteLink = this.closest('a');
            const deleteUrl = deleteLink.href;

            Swal.fire({
                title: 'Biztosan törölni szeretnéd?',
                text: "Ezt a műveletet nem lehet visszavonni!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Igen, törlöm!',
                cancelButtonText: 'Mégse',
                customClass: {
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-secondary'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Táblázat elhalványítása
                    const tbody = document.querySelector('#cowTable tbody');
                    if (tbody) {
                        tbody.style.opacity = '0';
                        tbody.style.transform = 'translateY(-10px)';
                    }
                    
                    // Kis késleltetés után átirányítás a törlés URL-re
                    setTimeout(() => {
                        window.location.href = deleteUrl;
                    }, 300);
                }
            });
        });
    });
});