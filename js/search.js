function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

let currentPage = 1;

function createPagination(totalPages, currentPage) {
    const paginationContainer = document.createElement('div');
    paginationContainer.className = 'pagination';
    
    // Előző oldal gomb
    if (currentPage > 1) {
        const prevButton = document.createElement('button');
        prevButton.innerHTML = '&laquo; Előző';
        prevButton.onclick = () => loadPage(currentPage - 1);
        paginationContainer.appendChild(prevButton);
    }
    
    // Oldalszámok
    for (let i = 1; i <= totalPages; i++) {
        const pageButton = document.createElement('button');
        pageButton.textContent = i;
        if (i === currentPage) {
            pageButton.className = 'active';
        }
        pageButton.onclick = () => loadPage(i);
        paginationContainer.appendChild(pageButton);
    }
    
    // Következő oldal gomb
    if (currentPage < totalPages) {
        const nextButton = document.createElement('button');
        nextButton.innerHTML = 'Következő &raquo;';
        nextButton.onclick = () => loadPage(currentPage + 1);
        paginationContainer.appendChild(nextButton);
    }
    
    return paginationContainer;
}

function loadPage(page) {
    currentPage = page;
    myFunction();
}

function myFunction() {
    const input = document.getElementById("myInput");
    const searchValue = input.value.trim();
    const table = document.getElementById("cowTable");
    const tbody = table.getElementsByTagName("tbody")[0];

    if (searchValue === "") {
        location.reload();
        return;
    }
   
    fetch(`search_cow.php?search=${encodeURIComponent(searchValue)}&page=${currentPage}`)
        .then(response => response.json())
        .then(data => {
            tbody.innerHTML = "";
        

            data.cows.forEach(cow => {
                const row = document.createElement("tr");
                row.innerHTML = `
                <td><img src="${cow.picture}" alt="Tehén Kép"></td>
                <td>${cow.ear_tag}</td>
                <td>${cow.gender}</td>
                <td>${cow.mother_ear_tag}</td>
                <td class="color">${cow.color || 'N/A'}</td>
                <td>${cow.birthdate}</td>
                <td class='btn-update borderRight'>
                    <a href='edit_cow.php?id=${encodeURIComponent(cow.cow_id)}'>
                        <button class='edit-button'>
                           <svg class='edit-svgIcon' viewBox='0 0 512 512'>
                                <path d='M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z'></path>
                            </svg>
                        </button>
                    </a>
                </td>
                <td class='btn-update borderRight'>
                    <button class='deleteButton' onclick="deleteCow(${cow.cow_id})">
                        <svg viewBox='0 0 448 512' class='svgIcon'>
                            <path d='M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z'></path>
                        </svg>
                    </button>
                </td>
            `;
                tbody.appendChild(row);
            });    

            // Lapozó létrehozása
            const existingPagination = document.querySelector('.pagination');
            if (existingPagination) {
                existingPagination.remove();
            }
            const pagination = createPagination(data.pagination.total_pages, data.pagination.current_page);
            table.parentNode.appendChild(pagination);

            // Színek fordítása
            if (typeof translateColors === "function") {
                translateColors();
            }
        })
        .catch(error => {
            console.error('Hiba történt:', error);
        });
}

// Törlés funkció módosítása SweetAlert használatával
function deleteCow(cowId) {
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
            fetch(`delete_cow.php?id=${cowId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Törölve!',
                        text: 'A tehén sikeresen törölve lett.',
                        icon: 'success',
                        confirmButtonColor: 'rgba(16, 86, 82, 0.8)',
                        background: '#fff',
                        customClass: {
                            popup: 'pagination-popup',
                            confirmButton: 'pagination-confirm'
                        }
                    }).then(() => {
                        location.reload(); // vagy frissítés / elem törlés JS-ből
                    });
                } else {
                    throw new Error(data.message || 'Hiba történt a törlés során');
                }
            })
            .catch(error => {
                console.error('Hiba:', error);
                Swal.fire({
                    title: 'Hiba!',
                    text: error.message || 'A törlés során hiba történt.',
                    icon: 'error',
                    confirmButtonColor: '#d33',
                    background: '#fff',
                    customClass: {
                        popup: 'pagination-popup',
                        confirmButton: 'pagination-confirm'
                    }
                });
            });
        }
    });
}


// Debounce alkalmazása a keresésre
const debouncedSearch = debounce(myFunction, 300);

// Event listener hozzáadása
let myInput = document.getElementById("myInput");
if (myInput != null) myInput.addEventListener("input", debouncedSearch);
// CSS a lapozóhoz
const style = document.createElement('style');
style.textContent = `
@keyframes pulseActive {
    0% { transform: translateY(-3px) scale(1); }
    50% { transform: translateY(-3px) scale(1.05); }
    100% { transform: translateY(-3px) scale(1); }
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateX(-20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}
    .pagination {
        margin: 20px auto;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
        padding: 10px;
    }

    .pagination a {
        background-color: aliceblue;
        color: #333;
        padding: 8px 16px;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s, transform 0.3s;
        min-width: 40px;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .pagination a.active {
        background-color: #606c38;
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        animation: pulseActive 2s infinite;
    }

    .pagination a:not(.active):hover {
        background-color: #283618;
        color: white;
        transform: translateY(-2px);
    }

`;
document.head.appendChild(style);