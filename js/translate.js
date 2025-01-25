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

function translateColors() {
    const colorCells = document.querySelectorAll('td.color');
    colorCells.forEach(cell => {
        const englishColor = cell.textContent.trim();
        if (colorTranslations[englishColor]) {
            cell.textContent = colorTranslations[englishColor];
        }
    });
}

window.addEventListener('DOMContentLoaded', translateColors);


console.log("hello")