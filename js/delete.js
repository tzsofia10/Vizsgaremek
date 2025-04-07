console.log("Delete script loaded");

document.addEventListener("DOMContentLoaded", () => {
    // Csak a SweetAlert-es deleteButton-ok kezelése
    document.querySelectorAll('.deleteButton').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            const deleteUrl = this.getAttribute('data-delete-url');

            Swal.fire({
                title: 'Biztosan törölni szeretnéd?',
                text: "A művelet nem visszafordítható!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: 'rgba(16, 86, 82, 0.8)',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Igen, törlöm!',
                cancelButtonText: 'Mégsem',
                background: '#fff',
                customClass: {
                    popup: 'pagination-popup',
                    confirmButton: 'pagination-confirm',
                    cancelButton: 'pagination-cancel'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Törlés végrehajtása
                    window.location.href = deleteUrl;
                }
            });
        });
    });
});
