//categories
function subCategorieDisplay() {
    let position = document.querySelector("#position");
    let divSubCategorie = document.querySelector(".subcategorie-select");
    let subCheck = document.querySelector("input[name=as_sub]");
    subCheck.checked ?
        ((divSubCategorie.style.display = "block"),
            (position.style.display = "none")) :
        "";

    subCheck.addEventListener("change", function() {
        if (this.checked) {
            divSubCategorie.style.display = "block";
            position.style.display = "none";
        } else {
            divSubCategorie.style.display = "none";
            position.style.display = "block";
        }
    });
}

document
    .querySelector("input[name=as_sub]")
    .addEventListener("change", function() {
        this.checked ?
            ((divSubCategorie.style.display = "block"),
                (position.style.display = "none")) :
            ((divSubCategorie.style.display = "none"),
                (position.style.display = "block"));
    });

function clearSelectedCat() {
    var elements = document.getElementById("category-select").options;
    for (var i = 0; i < elements.length; i++) {
        elements[i].selected = false;
    }
}

function clearSelectedOpt() {
    var elements = document.getElementById("option-select").options;
    for (var i = 0; i < elements.length; i++) {
        elements[i].selected = false;
    }
}

function clearSelectedSubCat() {
    var elements = document.getElementById("subcategory-select").options;
    for (var i = 0; i < elements.length; i++) {
        elements[i].selected = false;
    }
}

function clearSelectedProductBanner() {
    var elements = document.getElementById("product-banner-select").options;
    for (var i = 0; i < elements.length; i++) {
        elements[i].selected = false;
    }
}
//front-end
var uploadfoto = document.getElementById("banner-input");
var fotopreview = document.getElementById("banner-preview");

if (uploadfoto) {
    uploadfoto.addEventListener("change", function(e) {
        showThumbnail(this.files);
    });

    function showThumbnail(files) {
        if (files && files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                fotopreview.src = e.target.result;
            };

            reader.readAsDataURL(files[0]);
        }
    }
}

let midRadioChoice = document.querySelectorAll("input[name=radioMid]");
let divProductMid = document.querySelector(".product_link");
let divCategorieMid = document.querySelector(".category_link");
let divSubCategorieMid = document.querySelector(".subcategory_link");
midRadioChoice.forEach(function(el, k) {
    $(el).change(function() {
        if (el.value == "product") {
            divProductMid.style.display = "block";
        } else {
            divProductMid.style.display = "none";
        }
        if (el.value == "cat") {
            divCategorieMid.style.display = "block";
        } else {
            divCategorieMid.style.display = "none";
        }
        if (el.value == "subcat") {
            divSubCategorieMid.style.display = "block";
        } else {
            divSubCategorieMid.style.display = "none";
        }
    });
});

var campoFiltro = document.querySelector("#filtrar-tabela");

campoFiltro.addEventListener("input", function() {
    console.log(this.value);
    var produtos = document.querySelectorAll(".product-line");

    if (this.value.length > 0) {
        for (var i = 0; i < produtos.length; i++) {
            var produto = produtos[i];
            var tdNome = produto.querySelector(".product-name");
            var nome = tdNome.textContent;
            var expressao = new RegExp(this.value, "i");

            if (!expressao.test(nome)) {
                produto.classList.add("invisivel");
            } else {
                produto.classList.remove("invisivel");
            }
        }
    } else {
        for (var i = 0; i < produtos.length; i++) {
            var produto = produtos[i];
            produto.classList.remove("invisivel");
        }
    }
});
