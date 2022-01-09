//Masquer tout l'affichage si aucune recherche n'a déjà été effectuée
function displayButton() {
    let main = document.getElementById("main");
    let intro = document.getElementById("welcome");
    let grid = document.getElementsByClassName("ag-root-wrapper");
    let results = document.getElementById("results");
    let stats = document.getElementById("stats");

    if (grid.length === 0) {
        main.style.minHeight = "80vh";
        results.style.display = "none";
        stats.style.display = "none";
    } else {
        main.style.minHeight = "auto";
        intro.style.display = "none";
        results.style.display = "flex";
        stats.style.display = "flex";
    }
}

//Plier / déplier les catégories
function toggleFold(section) {
    let cat = document.getElementById(section);

    if (section === "container-results") {
        if (cat.style.display === "flex") {
            cat.style.display = "none";
        } else cat.style.display = "flex";
    }
    else {
        if (cat.style.display === "block") {
            cat.style.display = "none";
        } else cat.style.display = "block";
    }

}