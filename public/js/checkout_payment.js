console.log(shipping);

function inputHandler(masks, max, event) {
    var c = event.target;
    var v = c.value.replace(/[^0-9]+/g, "");
    var m = c.value.length > max ? 1 : 0;
    VMasker(c).unMask();
    VMasker(c).maskPattern(masks[m]);
    c.value = VMasker.toPattern(v, masks[m]);
}

var cardMask = ['9999999999999999', '9999999999999999'];
var card = document.querySelector('input[name=numero_cartao]');
VMasker(card).maskPattern(cardMask[0]);
card.addEventListener('input', inputHandler.bind(undefined, cardMask, 16), false);

var cvvMask = ['999', '999'];
var cvvInput = document.querySelector('input[name=cvv_cartao]');
VMasker(cvvInput).maskPattern(cvvMask[0]);
cvvInput.addEventListener('input', inputHandler.bind(undefined, cvvMask, 3), false);

var monthMask = ['99', '99'];
var monthInput = document.querySelector('input[name=mes_cartao]');
VMasker(monthInput).maskPattern(monthMask[0]);
monthInput.addEventListener('input', inputHandler.bind(undefined, monthMask, 2), false);

var yearMask = ['9999', '9999'];
var yearInput = document.querySelector('input[name=ano_cartao]');
VMasker(yearInput).maskPattern(yearMask[0]);
yearInput.addEventListener('input', inputHandler.bind(undefined, yearMask, 4), false);

var cpfMask = ['999.999.999-99', '999.999.999-99'];
var cpfInput = document.querySelector('input[name=cpf_cartao]');
VMasker(cpfInput).maskPattern(cpfMask[0]);
cpfInput.addEventListener('input', inputHandler.bind(undefined, cpfMask, 14), false);

var birthMask = ['99/99/9999', '99/99/9999'];
var birthInput = document.querySelector('input[name=birth_cartao]');
VMasker(birthInput).maskPattern(cpfMask[0]);
birthInput.addEventListener('input', inputHandler.bind(undefined, birthMask, 10), false);

var celfoneMask = ['(99) 99999-9999', '(99) 99999-9999'];
var celfoneCartaoInput = document.querySelector('input[name=celfone_cartao]');
VMasker(celfoneCartaoInput).maskPattern(cpfMask[0]);
celfoneCartaoInput.addEventListener('input', inputHandler.bind(undefined, celfoneMask, 14), false);

//pagseguro events
var totalPayment = parseFloat(totalItens);
console.log(totalPayment);
let cardNumber = document.querySelector('input[name=numero_cartao]');
let spanBrand = document.querySelector('span.brand');
cardNumber.addEventListener('keyup', function() {
    if (cardNumber.value.length >= 6) {
        PagSeguroDirectPayment.getBrand({
            cardBin: cardNumber.value.substr(0, 6),
            success: function(res) {
                //let imgBrand = `<img src="https://stc.pagseguro.uol.com.br/public/img/payment-methods-flags/68x30/${res.brand.name}.png">`;
                let imgBrand = `<img src="http://127.0.0.1:8000/img/${res.brand.name}.png">`;
                spanBrand.innerHTML = imgBrand;
                document.querySelector('input[name=brand_cartao]').value = res.brand.name;
                getInstallments(totalPayment, res.brand.name);
            },
            error: function(err) {
                console.log(err);
            },
            complete: function(res) {

            }
        });
    };
});

let submitButton = document.querySelectorAll('form.processForm');
submitButton.forEach(function(el, k) {
    el.addEventListener('submit', function(event) {
        event.preventDefault();
        $('#modal').modal('show');
        let paymentType = event.target.dataset.paymentType;
        var cpfInput = document.querySelector('input[name=cpf_cartao]').value;
        var birthInput = document.querySelector('input[name=birth_cartao]').value;
        var celfoneCartaoInput = document.querySelector('input[name=celfone_cartao]').value;
        if (paymentType === 'creditcard') {
            PagSeguroDirectPayment.createCardToken({
                cardNumber: document.querySelector('input[name=numero_cartao]').value,
                brand: document.querySelector('input[name=brand_cartao]').value,
                cvv: document.querySelector('input[name=cvv_cartao]').value,
                expirationMonth: document.querySelector('input[name=mes_cartao]').value,
                expirationYear: document.querySelector('input[name=ano_cartao]').value,
                success: function(res) {
                    processPayment(res.card.token, paymentType, cpfInput, birthInput, celfoneCartaoInput);
                },
                error: function(err) {
                    window.location.replace(urlError);
                },
                complete: function(res) {

                }
            });
        };
        if (paymentType === 'boleto') {
            processPayment(null, paymentType, null, null, null);
        };
    });
});
//pagseguro functions
function processPayment(token, paymentType, cpfInput, birthInput, celfoneCartaoInput) {
    let data = {
        hash: PagSeguroDirectPayment.getSenderHash(),
        paymentType: paymentType,
        cpfCartao: cpfInput,
        birthDate: birthInput,
        celfone: celfoneCartaoInput,
        _token: csrf
    };
    if (paymentType == 'creditcard') {
        //dados cartão de crédito
        data.card_token = token;
        data.installment = document.querySelector('select.select_installments').value;
        data.card_name = document.querySelector('input[name=nome_cartao]').value;
    }
    $.ajax({
        type: 'POST',
        url: urlProccess,
        data: data,
        dataType: 'json',
        success: function(res) {
            window.location.replace(urlThanks);
        },
        error: function(err) {
            window.location.replace(urlError);
        }
    })
}

function getInstallments(amount, brand) {
    PagSeguroDirectPayment.getInstallments({
        amount: amount,
        brand: brand,
        maxInstallmentNoInterest: 0,
        success: function(res) {
            let selectInstallments = drawSelectInstallments(res.installments[brand]);
            document.querySelector('div.installments').innerHTML = selectInstallments;
            console.log(res);
        },
        complete: function(res) {

        },
        error: function(err) {}
    })
}

function drawSelectInstallments(installments) {
    let select = '<label>Opções de Parcelamento:</label>';
    select += '<select class="form-control select_installments">';
    var formato = { minimumFractionDigits: 2, style: 'currency', currency: 'BRL' };
    for (let l of installments) {

        select += `<option value="${l.quantity}|${l.installmentAmount}">${l.quantity}x de R$ ${l.installmentAmount.toLocaleString('pt-BR', formato)} - Total fica R$ ${l.totalAmount.toLocaleString('pt-BR', formato)}</option>`;
    }
    select += '</select>';
    return select;
}