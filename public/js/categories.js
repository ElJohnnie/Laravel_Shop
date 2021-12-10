function subCategorieDisplay() {
    let asSub = document.querySelector("input[name=as_sub]");
    let position = document.querySelector("#position");
    let divSubCategorie = document.querySelector(".subcategorie-select");
    asSub
        ?
        ((divSubCategorie.style.display = "block"),
            (position.style.display = "none")) :
        ((divSubCategorie.style.display = "none"),
            (position.style.display = "block"));
}
