document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("searchInput");
    const cowTableBody = document.querySelector("#cowTable tbody");
    const paginationContainer = document.querySelector(".pagination-container");

    async function fetchCows(search = "", page = 1) {
        try {
            const response = await fetch(`searchcow.php?search=${encodeURIComponent(search)}&page=${page}`);
            if (!response.ok) throw new Error("Hálózati hiba történt!");

            const data = await response.json();
            updateTable(data.cows);
            updatePagination(data.pagination, search);
        } catch (error) {
            console.error("Hiba történt:", error);
        }
    }

    function updateTable(cows) {
        cowTableBody.innerHTML = ""; // Tábla ürítése
        if (cows.length === 0) {
            cowTableBody.innerHTML = `<tr><td colspan="6">Nincs találat.</td></tr>`;
            return;
        }

        const rows = cows.map(cow => `
            <tr>
                <td>${cow.ear_tag}</td>
                <td>${cow.gender}</td>
                <td>${cow.mother_ear_tag || '-'}</td>
                <td>${cow.color}</td>
                <td>${cow.birthdate}</td>
                <td><img src="${cow.picture}" alt="Tehén kép" width="50"></td>
            </tr>`).join('');
        
        cowTableBody.innerHTML = rows;
    }

    // Keresőmező animálása
    searchInput.addEventListener("focus", function () {
        this.classList.add("active");
    });

    searchInput.addEventListener("blur", function () {
        this.classList.remove("active");
    });

    // Keresés indítása input változásakor
    searchInput.addEventListener("input", function () {
        fetchCows(this.value);
    });

    // Alapértelmezett betöltés
    fetchCows();

    // Oldalszám megadás kezelése
    document.querySelectorAll('.dots').forEach(dots => {
        dots.addEventListener('click', function (e) {
            e.preventDefault();

            Swal.fire({
                title: 'Oldalszám megadása',
                input: 'number',
                inputLabel: 'Írja be a kívánt oldalszámot',
                inputPlaceholder: 'pl.: 5',
                showCancelButton: true,
                confirmButtonText: 'Ugrás',
                cancelButtonText: 'Mégse',
                inputAttributes: {
                    min: 1,
                    max: paginationContainer.querySelector('.pagination').dataset.maxPages || 100,
                    step: 1
                },
                inputValidator: (value) => {
                    if (!value || value < 1) {
                        return 'Kérem adjon meg egy érvényes oldalszámot!';
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const tbody = document.querySelector('#cowTable tbody');
                    tbody.style.opacity = '0';
                    tbody.style.transform = 'translateY(-10px)';

                    setTimeout(() => {
                        window.location.href = `?page=${result.value}`;
                    }, 300);
                }
            });
        });
    });
});
