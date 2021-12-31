function displayButtons() {
    let grid = document.getElementsByClassName("ag-root-wrapper");
    let boutons = document.getElementById("buttons");

    if (grid.length === 0) {
        boutons.style.display = "none";
    } else boutons.style.display = "flex";
}