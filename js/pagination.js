// Oldal betöltés animáció
document.addEventListener('DOMContentLoaded', function() {
    // Kiszámoljuk a maximális oldalszámot
    const maxPages = parseInt(document.querySelector('.pagination').dataset.maxPages) || 10;

    // Minden lapozó linkre feliratkozunk
    document.querySelectorAll('.pagination a').forEach(link => {
        if (!link.classList.contains('dots')) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const href = this.getAttribute('href');
                
                // Táblázat elhalványítása
                const tbody = document.querySelector('#cowTable tbody');
                tbody.style.opacity = '0';
                tbody.style.transform = 'translateY(-10px)';
                
                // Kis késleltetés után átirányítás
                setTimeout(() => {
                    window.location.href = href;
                }, 300);
            });
        }
    });

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
                    max: maxPages,
                    step: 1
                },
                inputValidator: (value) => {
                    if (!value || value < 1) {
                        return 'Kérem adjon meg egy érvényes oldalszámot!';
                    }
                    if (value > maxPages) {
                        return `Az oldalszám nem lehet nagyobb mint ${maxPages}!`;
                    }
                },
                customClass: {
                    container: 'pagination-alert',
                    popup: 'pagination-popup',
                    input: 'pagination-input',
                    confirmButton: 'pagination-confirm',
                    cancelButton: 'pagination-cancel'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Táblázat elhalványítása
                    const tbody = document.querySelector('#cowTable tbody');
                    if (tbody) {
                        tbody.style.opacity = '0';
                        tbody.style.transform = 'translateY(-10px)';
                    }
                    
                    // Kis késleltetés után átirányítás
                    setTimeout(() => {
                        window.location.href = `?page=${result.value}`;
                    }, 300);
                }
            });
        });
    });
});

// Eredeti jumpToPage funkció megtartása
function jumpToPage(currentPage, totalPages) {
    Swal.fire({
        title: 'Ugrás oldalra',
        input: 'number',
        inputAttributes: {
            min: 1,
            max: totalPages,
            step: 1
        },
        inputValue: currentPage,
        showCancelButton: true,
        confirmButtonText: 'Ugrás',
        cancelButtonText: 'Mégse',
        confirmButtonColor: '#A8C27A',
        inputValidator: (value) => {
            if (!value || value < 1 || value > totalPages) {
                return 'Kérlek adj meg egy számot 1 és ' + totalPages + ' között!';
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const tbody = document.querySelector('#cowTable tbody');
            tbody.style.opacity = '0';
            tbody.style.transform = 'translateY(-10px)';
            
            setTimeout(() => {
                window.location.href = '?page=' + result.value + '#cowTable';
            }, 300);
        }
    });
} 