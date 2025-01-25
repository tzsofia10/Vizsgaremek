const colorTranslations = {
    'Black' : 'Fekete',
    'Brown' : 'Barna',
    'White' : 'Fehér',
    'Spotted' : 'Foltos'
};

function translateColors() {
    const options = document.querySelectorAll('option');
    options.forEach(option => {
        const englishColor = option.textContent.trim();
        if (colorTranslations[englishColor]) {
            option.textContent = colorTranslations[englishColor];
        }
    });
}

// oldal betöltésénél fusson a fordítást
window.addEventListener('DOMContentLoaded', translateColors);


console.log("hello")