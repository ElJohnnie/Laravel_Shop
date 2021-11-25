function addOp(id, option) {
    data = {
        id: id,
        option: option,
        op: "add",
        hasOp: true,
        _token: token
    };
    sessionStorage.setItem("reloading", true);
    toAjax(data);
}

function removeOp(id, option) {
    data = {
        id: id,
        option: option,
        op: "remove",
        hasOp: true,
        _token: token
    };
    sessionStorage.setItem("reloading", true);
    toAjax(data);
}

function removeOnCart(id, option) {
    data = {
        id: id,
        option: option,
        _token: token
    };
    sessionStorage.setItem("reloading", true);
    toRemove(data);
}

function toAjax(data) {
    $.ajax({
        type: "POST",
        url: urlCart,
        data: data,
        dataType: "json",
        success: function(res) {
            document.location.reload();
            var session = sessionStorage.getItem("reloading");
            window.onload = function() {
                if (session) {
                    sessionStorage.removeItem("reloading");
                }
            };
        },
        error: function(err) {
            console.log(err);
        },
        complete: function(res) {
            //console.log(res);
        }
    });
}

function toRemove(data) {
    $.ajax({
        type: "POST",
        url: urlRemove,
        data: data,
        dataType: "json",
        success: function(res) {
            document.location.reload();
            var session = sessionStorage.getItem("reloading");
            window.onload = function() {
                if (session) {
                    sessionStorage.removeItem("reloading");
                }
            };
        },
        error: function(err) {
            console.log(err);
        },
        complete: function(res) {
            //console.log(res);
        }
    });
}

function message(data) {
    if (data == "ok") {
        let alertMessage = document.getElementById("alert");
        let theMessage =
            '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Holy guacamole!</strong> You should check in on some of those fields below.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
        alertMessage.innerHTML = theMessage;
    }
    if (data == "nOk") {
        let alertMessage = document.querySelector(".alert");
        let theMessage =
            '<div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>Holy guacamole!</strong> You should check in on some of those fields below.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
        alertMessage.innerHTML = theMessage;
    }
}

var getCep = document.querySelector("input[name=cep]").value;
var cep = getCep.replace("-", "");
var fieldFrete = document.querySelector(".cart_frete");
var fieldTotal = document.querySelector(".total_cart");
let dadosCorreios = {
    cep: cep,
    wheight: "0.900",
    length: "30",
    height: "15",
    widtht: "30",
    mainHand: "n",
    diameter: "70",
    _token: token
};

$.ajax({
    type: "POST",
    url: urlCorreios,
    data: dadosCorreios,
    dataType: "json",
    success(res) {
        var sedex = Object.values(res.data.sedex);
        var PAC = Object.values(res.data.PAC);
        var sedexParse = JSON.parse(sedex);
        var PACParse = JSON.parse(PAC);
        console.log(PACParse);
        fieldFreteFunction(sedexParse.valor, PACParse.valor, fieldFrete);
        cartTotal(productsTotal, PACParse.valor, fieldTotal);
    },
    error: function(err) {
        console.log(err);
    }
});

function fieldFreteFunction(sedex, PAC, field) {
    let format = {
        minimumFractionDigits: 2,
        style: "currency",
        currency: "BRL"
    };
    var frete = parseFloat(PAC);
    return (field.innerHTML = `${frete.toLocaleString("pt-BR", format)}`);
}

function cartTotal(products, frete, field) {
    let format = {
        minimumFractionDigits: 2,
        style: "currency",
        currency: "BRL"
    };
    var totalPayment = parseFloat(frete) + parseFloat(products);
    console.log(` R$ ${totalPayment.toLocaleString("pt-BR", format)}`);
    return (field.innerHTML = `${totalPayment.toLocaleString(
        "pt-BR",
        format
    )}`);
}
