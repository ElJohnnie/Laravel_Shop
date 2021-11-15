/* JS Document */

$.ajax({
    type: 'GET',
    url: addressUrl,
    dataType: 'json',
    success(res) {
        var sedex = Object.values(res.data.sedex);
        var PAC = Object.values(res.data.PAC);
        let format = { minimumFractionDigits: 2, style: 'currency', currency: 'BRL' };
        var sedexParse = JSON.parse(sedex);
        var PACParse = JSON.parse(PAC);
        shippingPlace = document.querySelector('.shipping-place');
        sedexInput = '<div class="form-check my-2"><input class="form-check-input" type="radio" name="shipping" id="shipping1" value="' + sedexParse.valor.toLocaleString('pt-BR', format) + '" checked><label class="form-check-label" for="shipping1">Sedex: R$' + sedexParse.valor + ', prazo de entrega: ' + sedexParse.prazo + ' dias.</label></div>';
        pacInput = '<div class="form-check my-2"><input class="form-check-input" type="radio" name="shipping" id="shipping2" value="' + PACParse.valor.toLocaleString('pt-BR', format) + '"><label class="form-check-label" for="shipping2">PAC: R$' + PACParse.valor + ', prazo de entrega: ' + PACParse.prazo + ' dias.</label></div>';
        shippingPlace.innerHTML = sedexInput + pacInput;
    },
    error: function(err) {
        console.log(err);
    }

});