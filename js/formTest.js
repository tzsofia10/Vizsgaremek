
// Ez a függvény akkor fut le, amikor az oldal teljesen betöltődik
window.onload = function() {
    autoFillForm(); // Az autoFillForm függvény meghívása
}

// Az űrlap mezőinek automatikus kitöltésére szolgáló függvény
function autoFillForm() {
    // Mintául szolgáló adatok (ezeket tetszés szerint módosíthatod)
    const sampleData = {
        ear_tag: '12345ABC', 
        gender: '0', 
        mother_ear_tag: '54321DEF', 
        color_id: '2', 
        birthdate: '2023-01-01', 
        picture: '' 
    };

    // Kitöltjük az űrlap mezőket a sampleData-ban megadott értékekkel
    document.getElementById('ear_tag').value = sampleData.ear_tag; 
    document.getElementById('gender').value = sampleData.gender; 
    document.getElementById('mother_ear_tag').value = sampleData.mother_ear_tag;
    document.getElementById('father_ear_tag').value = sampleData.father_ear_tag;
    document.getElementById('color_id').value = sampleData.color_id; 
    document.getElementById('birthdate').value = sampleData.birthdate; 

    // Opcionálisan: Kép feltöltésének szimulálása (JavaScript nem tud közvetlenül fájlt beállítani a fájl input mezőnél biztonsági okokból)
    if (sampleData.picture) {
        document.getElementById('picture').value = sampleData.picture; 
    }
}
