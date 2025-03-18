document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("searchInput");
    const cowTableBody = document.querySelector("#cowTable tbody");
    const paginationContainer = document.querySelector(".pagination-container");

    function fetchCows(search = "", page = 1) {
        fetch(`searchcow.php?search=${encodeURIComponent(search)}&page=${page}`)
            .then(response => response.json())
            .then(data => {
                updateTable(data.cows);
                updatePagination(data.pagination, search);
            })
            .catch(error => console.error("Hiba történt:", error));
    }

    function updateTable(cows) {
        cowTableBody.innerHTML = ""; // Tábla ürítése
        if (cows.length === 0) {
            cowTableBody.innerHTML = `<tr><td colspan="6">Nincs találat.</td></tr>`;
            return;
        }

        cows.forEach(cow => {
            const row = `
                <tr>
                    <td>${cow.ear_tag}</td>
                    <td>${cow.gender}</td>
                    <td>${cow.mother_ear_tag || '-'}</td>
                    <td>${cow.color}</td>
                    <td>${cow.birthdate}</td>
                    <td><img src="${cow.picture}" alt="Tehén kép" width="50"></td>
                </tr>`;
            cowTableBody.innerHTML += row;
        });
    }

    // Keresőmező eseménykezelője
    searchInput.addEventListener("input", function () {
        fetchCows(this.value);
    });

    // Alapértelmezett betöltés
    fetchCows();

    // Dots elemek kezelése
    document.querySelectorAll('.dots').forEach(dots => {
        dots.addEventListener('click', function(e) {
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
                    max: paginationContainer.querySelector('.pagination').dataset.maxPages,
                    step: 1
                },
                inputValidator: (value) => {
                    if (!value || value < 1) {
                        return 'Kérem adjon meg egy érvényes oldalszámot!';
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Táblázat elhalványítása
                    const tbody = document.querySelector('#cowTable tbody');
                    tbody.style.opacity = '0';
                    tbody.style.transform = 'translateY(-10px)';
                    
                    // Kis késleltetés után átirányítás
                    setTimeout(() => {
                        window.location.href = `?page=${result.value}`;
                    }, 300);
                }
            });
        });
    });
});

