let yAddress = document.querySelector("input[value=yAddress]");
let nAddress = document.querySelector("input[value=nAddress]");
let addressChoice = document.querySelector("div.address-inputs");
let billingChoice = document.querySelector("div.shipping-btns");
$(yAddress).change(function() {
    let yInputsAddress =
        '<div class="col-md-8 address-input"> <input name="street" value="' +
        userInformations.Address +
        '" type="text" placeholder="' +
        userInformations.Address +
        '" readonly> </div> <div class="col-md-4 address-input"> <input name="number" type="text" value="' +
        userInformations.Number +
        '" placeholder="' +
        userInformations.Number +
        '" readonly> </div> <div class="col-md-6 address-input"> <input name="district" value="' +
        userInformations.District +
        '" type="text" placeholder="' +
        userInformations.District +
        '" readonly> </div> <div class="col-md-6 address-input"> <input name="complement" value="' +
        userInformations.Complement +
        '" type="text" placeholder="Complemento"' +
        userInformations.Complement +
        '" readonly> </div> <div class="col-md-6 address-input"> <input name="city" value="' +
        userInformations.City +
        '" type="text" placeholder="' +
        userInformations.City +
        '" readonly> </div> <div class="col-md-3 address-input"> <input name="state" value="' +
        userInformations.State +
        '" type="text" placeholder="' +
        userInformations.State +
        '" readonly> </div> <div class="col-md-3 address-input"> <input name="country" value="' +
        userInformations.Country +
        '" type="text" placeholder="' +
        userInformations.Country +
        '" readonly> </div> <div class="col-md-6 address-input"><input name="cep" value="' +
        userInformations.CEP +
        '" type="text" placeholder="' +
        userInformations.CEP +
        '" readonly> </div> <div class="col-md-6 address-input"> <input name="contact" type="text" value="' +
        userInformations.Celfone +
        '" type="text" placeholder="' +
        userInformations.Celfone +
        '" readonly> </div>';
    if (this.checked) {
        billingChoice.innerHTML = "";
        addressChoice.innerHTML = yInputsAddress;
        var getCep = document.querySelector("input[name=cep]").value;
        var cep = getCep.replace("-", "");
        let userAddress = {
            address: document.querySelector("input[name=street]").value,
            number: document.querySelector("input[name=number]").value,
            district: document.querySelector("input[name=district]").value,
            complement: document.querySelector("input[name=complement]").value,
            city: document.querySelector("input[name=city]").value,
            state: document.querySelector("input[name=state]").value,
            country: document.querySelector("input[name=country]").value,
            cep: cep,
            contact: document.querySelector("input[name=contact]").value
        };

        let dadosCorreios = {
            cep: cep,
            wheight: "0.900",
            length: "30",
            height: "15",
            widtht: "30",
            mainHand: "n",
            diameter: "70",
            _token: csrf
        };
        $.ajax({
            type: "POST",
            url: urlFrete,
            data: dadosCorreios,
            dataType: "json",
            success(res) {
                var sedex = Object.values(res.data.sedex);
                var PAC = Object.values(res.data.PAC);
                const billingInputs =
                    '<div class="col-md-5"><form><div class="form-check"><input class="form-check-input" type="radio" name="billing" id="pac" value="' +
                    PAC +
                    '" data-billing="PAC"><label class="form-check-label" for="pac">PAC R$' +
                    PAC +
                    '</label></div><div class="form-check"><input class="form-check-input" type="radio" name="billing" id="sedex" value="' +
                    sedex +
                    '" data-billing="sedex"><label class="form-check-label" for="sedex">Sedex R$' +
                    sedex +
                    "</label></div></form></div>";
                billingChoice.innerHTML = billingInputs;
                const billingTotal = document.querySelector(".billingTotal");
                let cartTotal = document.querySelector("li.total");
                let PACInput = document.querySelector("input[id=pac]");
                let sedexInput = document.querySelector("input[id=sedex]");

                let billingType = document.querySelectorAll(
                    "input[name=billing]"
                );
                let formato = {
                    minimumFractionDigits: 2,
                    style: "currency",
                    currency: "BRL"
                };
                billingType.forEach(function(el, k) {
                    $(el).change(function() {
                        if (this.checked) {
                            let billingType = this.dataset.billing;
                            console.log(billingType);
                            if (billingType === "PAC") {
                                billingTotal.innerHTML = `Frete: R$ ${PAC.toLocaleString(
                                    "pt-BR",
                                    formato
                                )}`;
                                var totalPayment =
                                    parseFloat(PAC) + parseFloat(totalItens);
                                cartTotal.innerHTML = `Total: R$ ${totalPayment.toLocaleString(
                                    "pt-BR",
                                    formato
                                )}`;
                                billingValue = parseFloat(PAC).toFixed(2);
                            }
                            if (billingType === "sedex") {
                                billingTotal.innerHTML = `Frete: R$ ${sedex.toLocaleString(
                                    "pt-BR",
                                    formato
                                )}`;
                                var totalPayment =
                                    parseFloat(sedex) + parseFloat(totalItens);
                                cartTotal.innerHTML = `Total: R$ ${totalPayment.toLocaleString(
                                    "pt-BR",
                                    formato
                                )}`;
                                billingValue = parseFloat(sedex).toFixed(2);
                            }
                            const paymentPlace = document.querySelector(
                                ".payment_place"
                            );
                            paymentPlace.innerHTML =
                                '<div class="card"><div class="card-header" id="headingOne"><h2 class="mb-0"><button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Cartão de crédito.</button></h2></div><div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample"><div class="card"><div class="card-body"><div class="card credit-card"><div class="card-body"><h6 class="card-subtitle mb-2 text-muted">Cartão de crédito</h6><h5 id="mockup-number" style="font-size: calc(20px + .5vw);" class="mockup-number text-muted mt-3">0000000000000000</h5><h6 id="mockup-name" class="card-subtitle mt-3 mb-3 text-muted">Jane Doe</h6><div class="row"><div class="col d-flex flex-row"><div align="left" id="mockup-mes" class="mockup-date p-2 text-muted">MM</div><div id="mockup-ano" class="mockup-date p-2 text-muted">AAAA</div></div><div id="codeSegur" class="col p-2 d-flex text-muted justify-content-center">CVV</div><div class="col d-flex flex-row-reverse"><span class="brand justify"></span></div></div></div></div></div><form class="processForm mt-3" action="" method="post" data-payment-type="creditcard"><div class="row form-row mx-2"><div class="form-group col-md-6"><label for="">Nome no cartão</label><input type="text" class="form-control" name="nome_cartao" required></div><div class="form-group col-md-6"><label for="">Número do cartão. <span class="brand"></span></label><input type="text" class="form-control" name="numero_cartao" required><input type="hidden" name="brand_cartao"></div></div><div class="row form-row mx-2"><div class="form-group col-md-2"><label for="">Mês de expiração</label><input type="text" class="form-control" name="mes_cartao" required></div><div class="form-group col-md-2"><label for="">Ano de expiração.</label><input type="text" class="form-control" name="ano_cartao" required></div><div class="col-md-3"><label for="">Código de segurança</label><input type="text" class="form-control" name="cvv_cartao" required></div></div><div class="row form-row mx-2"><div class="col-md-4"><label for="">Cpf do titular</label><input type="text" class="form-control" name="cpf_cartao" required></div><div class="col-md-3"><label for="">Data de nascimento</label><input type="text" class="form-control" name="birth_cartao" required></div><div class="col-md-3"><label for="">Contato do titular</label><input type="text" class="form-control" name="celfone_cartao" required></div><div class="col-md-12 mb-4 installments"></div></div><button type="submit" class="site-btn submit-order-btn mt-3 processCheckout">Finalizar pedido</button></form></form></div></div></div><div class="card"><div class="card-header" id="headingTwo"><h2 class="mb-0"><button class="btn btn-link btn-block text-left collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Boleto bancário</button></h2></div><div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample"><form class="processForm" action="" method="post" data-payment-type="boleto"><div class="card-body"><button class="site-btn submit-order-btn processCheckout" type="submit">Finalizar pedido</button></div></form></div></div><div class="card"><div class="card-header" id="headingThree"><h2 class="mb-0"><button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Pagamento ao realizar a entrega</button></h2></div><div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample"><div class="card-body">Somente na região de Teutônia/RS.</div></div></div>';
                            //mockup do cartão
                            var cardNum = $("#mockup-number");
                            $("input[name=numero_cartao]").on(
                                "keyup",
                                function() {
                                    var texto = $(this).val();
                                    cardNum.text(texto);
                                }
                            );

                            var Cardname = $("#mockup-name");
                            $("input[name=nome_cartao]").on(
                                "keyup",
                                function() {
                                    var texto = $(this).val();
                                    Cardname.text(texto);
                                }
                            );

                            var cardMes = $("#mockup-mes");
                            $("input[name=mes_cartao]").on("keyup", function() {
                                var texto = $(this).val();
                                cardMes.text(texto);
                            });

                            var cardAno = $("#mockup-ano");
                            $("input[name=ano_cartao]").on("keyup", function() {
                                var texto = $(this).val();
                                cardAno.text(texto);
                            });

                            var cardAno = $("#mockup-ano");
                            $("input[name=ano_cartao]").on("keyup", function() {
                                var texto = $(this).val();
                                cardAno.text(texto);
                            });

                            var codeSegur = $("#codeSegur");
                            $("input[name=cvv_cartao]").on("keyup", function() {
                                var texto = $(this).val();
                                codeSegur.text(texto);
                            });

                            //máscara dos inputs do cartão

                            function inputHandler(masks, max, event) {
                                var c = event.target;
                                var v = c.value.replace(/[^0-9]+/g, "");
                                var m = c.value.length > max ? 1 : 0;
                                VMasker(c).unMask();
                                VMasker(c).maskPattern(masks[m]);
                                c.value = VMasker.toPattern(v, masks[m]);
                            }

                            var cardMask = [
                                "9999999999999999",
                                "9999999999999999"
                            ];
                            var card = document.querySelector(
                                "input[name=numero_cartao]"
                            );
                            VMasker(card).maskPattern(cardMask[0]);
                            card.addEventListener(
                                "input",
                                inputHandler.bind(undefined, cardMask, 16),
                                false
                            );

                            var cvvMask = ["999", "999"];
                            var cvvInput = document.querySelector(
                                "input[name=cvv_cartao]"
                            );
                            VMasker(cvvInput).maskPattern(cvvMask[0]);
                            cvvInput.addEventListener(
                                "input",
                                inputHandler.bind(undefined, cvvMask, 3),
                                false
                            );

                            var monthMask = ["99", "99"];
                            var monthInput = document.querySelector(
                                "input[name=mes_cartao]"
                            );
                            VMasker(monthInput).maskPattern(monthMask[0]);
                            monthInput.addEventListener(
                                "input",
                                inputHandler.bind(undefined, monthMask, 2),
                                false
                            );

                            var yearMask = ["9999", "9999"];
                            var yearInput = document.querySelector(
                                "input[name=ano_cartao]"
                            );
                            VMasker(yearInput).maskPattern(yearMask[0]);
                            yearInput.addEventListener(
                                "input",
                                inputHandler.bind(undefined, yearMask, 4),
                                false
                            );

                            var cpfMask = ["999.999.999-99", "999.999.999-99"];
                            var cpfInput = document.querySelector(
                                "input[name=cpf_cartao]"
                            );
                            VMasker(cpfInput).maskPattern(cpfMask[0]);
                            cpfInput.addEventListener(
                                "input",
                                inputHandler.bind(undefined, cpfMask, 14),
                                false
                            );

                            var birthMask = ["99/99/9999", "99/99/9999"];
                            var birthInput = document.querySelector(
                                "input[name=birth_cartao]"
                            );
                            VMasker(birthInput).maskPattern(cpfMask[0]);
                            birthInput.addEventListener(
                                "input",
                                inputHandler.bind(undefined, birthMask, 10),
                                false
                            );

                            var celfoneMask = [
                                "(99) 99999-9999",
                                "(99) 99999-9999"
                            ];
                            var celfoneCartaoInput = document.querySelector(
                                "input[name=celfone_cartao]"
                            );
                            VMasker(celfoneCartaoInput).maskPattern(cpfMask[0]);
                            celfoneCartaoInput.addEventListener(
                                "input",
                                inputHandler.bind(undefined, celfoneMask, 14),
                                false
                            );

                            //pagseguro events
                            let cardNumber = document.querySelector(
                                "input[name=numero_cartao]"
                            );
                            let spanBrand = document.querySelector(
                                "span.brand"
                            );
                            cardNumber.addEventListener("keyup", function() {
                                if (cardNumber.value.length >= 6) {
                                    PagSeguroDirectPayment.getBrand({
                                        cardBin: cardNumber.value.substr(0, 6),
                                        success: function(res) {
                                            //let imgBrand = `<img src="https://stc.pagseguro.uol.com.br/public/img/payment-methods-flags/68x30/${res.brand.name}.png">`;
                                            let imgBrand = `<img src="http://127.0.0.1:8000/img/${res.brand.name}.png">`;
                                            spanBrand.innerHTML = imgBrand;
                                            document.querySelector(
                                                "input[name=brand_cartao]"
                                            ).value = res.brand.name;
                                            getInstallments(
                                                totalPayment,
                                                res.brand.name
                                            );
                                        },
                                        error: function(err) {
                                            console.log(err);
                                        },
                                        complete: function(res) {
                                            console.log("Complete", res);
                                        }
                                    });
                                }
                            });

                            let submitButton = document.querySelectorAll(
                                "form.processForm"
                            );
                            submitButton.forEach(function(el, k) {
                                el.addEventListener("submit", function(event) {
                                    event.preventDefault();
                                    $("#modal").modal("show");
                                    let paymentType =
                                        event.target.dataset.paymentType;
                                    var cpfInput = document.querySelector(
                                        "input[name=cpf_cartao]"
                                    ).value;
                                    var birthInput = document.querySelector(
                                        "input[name=birth_cartao]"
                                    ).value;
                                    var celfoneCartaoInput = document.querySelector(
                                        "input[name=celfone_cartao]"
                                    ).value;
                                    if (paymentType === "creditcard") {
                                        PagSeguroDirectPayment.createCardToken({
                                            cardNumber: document.querySelector(
                                                "input[name=numero_cartao]"
                                            ).value,
                                            brand: document.querySelector(
                                                "input[name=brand_cartao]"
                                            ).value,
                                            cvv: document.querySelector(
                                                "input[name=cvv_cartao]"
                                            ).value,
                                            expirationMonth: document.querySelector(
                                                "input[name=mes_cartao]"
                                            ).value,
                                            expirationYear: document.querySelector(
                                                "input[name=ano_cartao]"
                                            ).value,
                                            success: function(res) {
                                                processPayment(
                                                    res.card.token,
                                                    paymentType,
                                                    cpfInput,
                                                    birthInput,
                                                    celfoneCartaoInput
                                                );
                                            },
                                            error: function(err) {
                                                $("#modal").modal("hide");
                                                window.location.href = `${urlError}`;
                                            },
                                            complete: function(res) {}
                                        });
                                    }
                                    if (paymentType === "boleto") {
                                        processPayment(null, paymentType);
                                    }
                                });
                            });
                            //pagseguro functions
                            function processPayment(
                                token,
                                paymentType,
                                cpfInput,
                                birthInput,
                                celfoneCartaoInput
                            ) {
                                let data = {
                                    hash: PagSeguroDirectPayment.getSenderHash(),
                                    paymentType: paymentType,
                                    billing: billingValue,
                                    billingAddress: userAddress,
                                    cpfCartao: cpfInput,
                                    birthDate: birthInput,
                                    celfone: celfoneCartaoInput,
                                    _token: csrf
                                };
                                if (paymentType == "creditcard") {
                                    //dados cartão de crédito
                                    data.card_token = token;
                                    data.installment = document.querySelector(
                                        "select.select_installments"
                                    ).value;
                                    data.card_name = document.querySelector(
                                        "input[name=nome_cartao]"
                                    ).value;
                                }
                                $.ajax({
                                    type: "POST",
                                    url: urlProccess,
                                    data: data,
                                    dataType: "json",
                                    success(res) {
                                        $("#modal").modal("hide");
                                        window.open(
                                            res.data.link_boleto,
                                            "Boleto da compra: " +
                                            res.data.order,
                                            "height=600,width=600"
                                        );
                                        window.location.href = `${urlThanks}?pedido='+${res.data.order}`;
                                    },
                                    error: function(err) {
                                        //window.location.href = `${urlError}?codigo=401`;
                                    }
                                });
                            }

                            function getInstallments(amount, brand) {
                                PagSeguroDirectPayment.getInstallments({
                                    amount: amount,
                                    brand: brand,
                                    maxInstallmentNoInterest: 0,
                                    success: function(res) {
                                        let selectInstallments = drawSelectInstallments(
                                            res.installments[brand]
                                        );
                                        document.querySelector(
                                            "div.installments"
                                        ).innerHTML = selectInstallments;
                                        console.log(res);
                                    },
                                    complete: function(res) {},
                                    error: function(err) {}
                                });
                            }

                            function drawSelectInstallments(installments) {
                                let select =
                                    "<label>Opções de Parcelamento:</label>";
                                select +=
                                    '<select class="form-control select_installments">';
                                var formato = {
                                    minimumFractionDigits: 2,
                                    style: "currency",
                                    currency: "BRL"
                                };
                                for (let l of installments) {
                                    select += `<option value="${l.quantity}|${
                                        l.installmentAmount
                                    }">${
                                        l.quantity
                                    }x de R$ ${l.installmentAmount.toLocaleString(
                                        "pt-BR",
                                        formato
                                    )} - Total fica R$ ${l.totalAmount.toLocaleString(
                                        "pt-BR",
                                        formato
                                    )}</option>`;
                                }
                                select += "</select>";
                                return select;
                            }
                        }
                    });
                });
            },

            error: function(err) {
                console.log(err);
            }
        });
    }
});

$(nAddress).change(function() {
    let nInputsAddress =
        '<div class="col-md-8 address-input"><input id="address-input" class="form-control" type="text" name="street" placeholder="Rua" minlength="5" maxlength="100" required> </div> <div class="col-md-4 address-input"> <input id="address-input" class="form-control" type="text" name="number" placeholder="Número" required></div><div class="col-md-6 address-input"> <input id="address-input" class="form-control" name="district" placeholder="Bairro" type="text" minlength="3" maxlength="100" required> </div> <div class="col-md-6 address-input"> <input name="complement" type="text" placeholder="Complemento(opcional)"> </div> <div class="col-md-6 address-input"> <input id="address-input" class="form-control" name="city" type="text" placeholder="Cidade" minlength="4" maxlength="100" required></div><div class="col-md-3 address-input"><select class="form-control" name="state" id="state" type="select" required><option value="" disabled selected>Estado</option><option value="AC">AC</option><option value="AL">AL</option><option value="AP">AP</option><option value="AM">AM</option><option value="BA">BA</option><option value="CE">CE</option><option value="DF">DF</option><option value="ES">ES</option><option value="GO">GO</option><option value="MA">MA</option><option value="MT">MT</option><option value="MS">MS</option><option value="MG">MG</option><option value="PA">PA</option><option value="PB">PB</option><option value="PR">PR</option><option value="PE">PE</option><option value="PI">PI</option><option value="RJ">RJ</option><option value="RN">RN</option><option value="RS">RS</option><option value="RO">RO</option><option value="RR">RR</option><option value="SC">SC</option><option value="SP">SP</option><option value="SE">SE</option><option value="TO">TO</option></select> </div> <div class="col-md-3 address-input"> <input class="form-control" name="country" value="' +
        userInformations.Country +
        '" type="text" placeholder="' +
        userInformations.Country +
        '" readonly required> </div> <div class="col-md-6 address-input"><input id="address-input" class="form-control" id="cep" name="cep" type="text" placeholder="CEP" minlength="7" maxlength="9" required></div> <div class="col-md-6 address-input"> <input id="address-input" class="form-control" type="text" name="contact" placeholder="Contato" minlength="13" maxlenght="13" required></div> <button type="submit" class="site-btn btn-sm normal-text">Calcular frete</button>';
    if (this.checked) {
        billingChoice.innerHTML = "";
        addressChoice.innerHTML = nInputsAddress;
        //mask inputs

        VMasker(document.querySelector("input[name=cep]")).maskPattern(
            "99999-9999"
        );
        VMasker(document.querySelector("input[name=contact]")).maskPattern(
            "(99) 99999-9999"
        );

        let submitFrete = document.querySelector("form.billing-form");
        submitFrete.addEventListener("submit", function(event) {
            event.preventDefault();
            var getCep = document.querySelector("input[name=cep]").value;
            var cep = getCep.replace("-", "");
            var e = document.getElementById("state");
            var stateUser = e.options[e.selectedIndex].text;
            let newAddress = {
                address: document.querySelector("input[name=street]").value,
                number: document.querySelector("input[name=number]").value,
                district: document.querySelector("input[name=district]").value,
                complement: document.querySelector("input[name=complement]")
                    .value,
                city: document.querySelector("input[name=city]").value,
                state: stateUser,
                country: document.querySelector("input[name=country]").value,
                cep: cep,
                contact: document.querySelector("input[name=contact]").value
            };
            let dadosCorreios = {
                cep: cep,
                wheight: "0.900",
                length: "30",
                height: "15",
                widtht: "30",
                mainHand: "n",
                diameter: "70",
                _token: csrf
            };
            $.ajax({
                type: "POST",
                url: urlFrete,
                data: dadosCorreios,
                dataType: "json",
                success(res) {
                    var sedex = Object.values(res.data.sedex);
                    var PAC = Object.values(res.data.PAC);
                    const billingInputs =
                        '<div class="col-md-5"><form><div class="form-check"><input class="form-check-input" type="radio" name="billing" id="pac" value="' +
                        PAC +
                        '" data-billing="PAC"><label class="form-check-label" for="pac">PAC R$' +
                        PAC +
                        '</label></div><div class="form-check"><input class="form-check-input" type="radio" name="billing" id="sedex" value="' +
                        sedex +
                        '" data-billing="sedex"><label class="form-check-label" for="sedex">Sedex R$' +
                        sedex +
                        "</label></div></form></div>";
                    billingChoice.innerHTML = billingInputs;
                    const billingTotal = document.querySelector(
                        ".billingTotal"
                    );
                    let cartTotal = document.querySelector("li.total");
                    let PACInput = document.querySelector("input[id=pac]");
                    let sedexInput = document.querySelector("input[id=sedex]");

                    let billingType = document.querySelectorAll(
                        "input[name=billing]"
                    );
                    let formato = {
                        minimumFractionDigits: 2,
                        style: "currency",
                        currency: "BRL"
                    };
                    billingType.forEach(function(el, k) {
                        $(el).change(function() {
                            if (this.checked) {
                                let billingType = this.dataset.billing;
                                console.log(billingType);
                                if (billingType === "PAC") {
                                    billingTotal.innerHTML = `Frete: R$ ${PAC.toLocaleString(
                                        "pt-BR",
                                        formato
                                    )}`;
                                    var totalPayment =
                                        parseFloat(PAC) +
                                        parseFloat(totalItens);
                                    cartTotal.innerHTML = `Total: R$ ${totalPayment.toLocaleString(
                                        "pt-BR",
                                        formato
                                    )}`;
                                    billingValue = parseFloat(PAC).toFixed(2);
                                }
                                if (billingType === "sedex") {
                                    billingTotal.innerHTML = `Frete: R$ ${sedex.toLocaleString(
                                        "pt-BR",
                                        formato
                                    )}`;
                                    var totalPayment =
                                        parseFloat(sedex) +
                                        parseFloat(totalItens);
                                    cartTotal.innerHTML = `Total: R$ ${totalPayment.toLocaleString(
                                        "pt-BR",
                                        formato
                                    )}`;
                                    billingValue = parseFloat(sedex).toFixed(2);
                                }
                                const paymentPlace = document.querySelector(
                                    ".payment_place"
                                );
                                paymentPlace.innerHTML =
                                    '<div class="card"><div class="card-header" id="headingOne"><h2 class="mb-0"><button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Cartão de crédito.</button></h2></div><div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample"><div class="card"><div class="card-body"><div class="card credit-card"><div class="card-body"><h6 class="card-subtitle mb-2 text-muted">Cartão de crédito</h6><h5 id="mockup-number" style="font-size: calc(20px + .5vw);" class="mockup-number text-muted mt-3">0000000000000000</h5><h6 id="mockup-name" class="card-subtitle mt-3 mb-3 text-muted">Jane Doe</h6><div class="row"><div class="col d-flex flex-row"><div align="left" id="mockup-mes" class="mockup-date p-2 text-muted">MM</div><div id="mockup-ano" class="mockup-date p-2 text-muted">AAAA</div></div><div id="codeSegur" class="col p-2 d-flex text-muted justify-content-center">CVV</div><div class="col d-flex flex-row-reverse"><span class="brand justify"></span></div></div></div></div></div><form class="processForm mt-3" action="" method="post" data-payment-type="creditcard"><div class="row form-row mx-2"><div class="form-group col-md-6"><label for="">Nome no cartão</label><input type="text" class="form-control" name="nome_cartao" required></div><div class="form-group col-md-6"><label for="">Número do cartão. <span class="brand"></span></label><input type="text" class="form-control" name="numero_cartao" required><input type="hidden" name="brand_cartao"></div></div><div class="row form-row mx-2"><div class="form-group col-md-2"><label for="">Mês de expiração</label><input type="text" class="form-control" name="mes_cartao" required></div><div class="form-group col-md-2"><label for="">Ano de expiração.</label><input type="text" class="form-control" name="ano_cartao" required></div><div class="col-md-3"><label for="">Código de segurança</label><input type="text" class="form-control" name="cvv_cartao" required></div></div><div class="row form-row mx-2"><div class="col-md-4"><label for="">Cpf do titular</label><input type="text" class="form-control" name="cpf_cartao" required></div><div class="col-md-3"><label for="">Data de nascimento</label><input type="text" class="form-control" name="birth_cartao" required></div><div class="col-md-3"><label for="">Contato do titular</label><input type="text" class="form-control" name="celfone_cartao" required></div><div class="col-md-12 mb-4 installments"></div></div><button type="submit" class="site-btn submit-order-btn mt-3 processCheckout">Finalizar pedido</button></form></form></div></div></div><div class="card"><div class="card-header" id="headingTwo"><h2 class="mb-0"><button class="btn btn-link btn-block text-left collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Boleto bancário</button></h2></div><div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample"><form class="processForm" action="" method="post" data-payment-type="boleto"><div class="card-body"><button class="site-btn submit-order-btn processCheckout" type="submit">Finalizar pedido</button></div></form></div></div><div class="card"><div class="card-header" id="headingThree"><h2 class="mb-0"><button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Pagamento ao realizar a entrega</button></h2></div><div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample"><div class="card-body">Somente na região de Teutônia/RS.</div></div></div>';
                                //mockup do cartão
                                var cardNum = $("#mockup-number");
                                $("input[name=numero_cartao]").on(
                                    "keyup",
                                    function() {
                                        var texto = $(this).val();
                                        cardNum.text(texto);
                                    }
                                );

                                var Cardname = $("#mockup-name");
                                $("input[name=nome_cartao]").on(
                                    "keyup",
                                    function() {
                                        var texto = $(this).val();
                                        Cardname.text(texto);
                                    }
                                );

                                var cardMes = $("#mockup-mes");
                                $("input[name=mes_cartao]").on(
                                    "keyup",
                                    function() {
                                        var texto = $(this).val();
                                        cardMes.text(texto);
                                    }
                                );

                                var cardAno = $("#mockup-ano");
                                $("input[name=ano_cartao]").on(
                                    "keyup",
                                    function() {
                                        var texto = $(this).val();
                                        cardAno.text(texto);
                                    }
                                );

                                var cardAno = $("#mockup-ano");
                                $("input[name=ano_cartao]").on(
                                    "keyup",
                                    function() {
                                        var texto = $(this).val();
                                        cardAno.text(texto);
                                    }
                                );

                                var codeSegur = $("#codeSegur");
                                $("input[name=cvv_cartao]").on(
                                    "keyup",
                                    function() {
                                        var texto = $(this).val();
                                        codeSegur.text(texto);
                                    }
                                );

                                //máscara dos inputs do cartão

                                function inputHandler(masks, max, event) {
                                    var c = event.target;
                                    var v = c.value.replace(/[^0-9]+/g, "");
                                    var m = c.value.length > max ? 1 : 0;
                                    VMasker(c).unMask();
                                    VMasker(c).maskPattern(masks[m]);
                                    c.value = VMasker.toPattern(v, masks[m]);
                                }

                                var cardMask = [
                                    "9999999999999999",
                                    "9999999999999999"
                                ];
                                var card = document.querySelector(
                                    "input[name=numero_cartao]"
                                );
                                VMasker(card).maskPattern(cardMask[0]);
                                card.addEventListener(
                                    "input",
                                    inputHandler.bind(undefined, cardMask, 16),
                                    false
                                );

                                var cvvMask = ["999", "999"];
                                var cvvInput = document.querySelector(
                                    "input[name=cvv_cartao]"
                                );
                                VMasker(cvvInput).maskPattern(cvvMask[0]);
                                cvvInput.addEventListener(
                                    "input",
                                    inputHandler.bind(undefined, cvvMask, 3),
                                    false
                                );

                                var monthMask = ["99", "99"];
                                var monthInput = document.querySelector(
                                    "input[name=mes_cartao]"
                                );
                                VMasker(monthInput).maskPattern(monthMask[0]);
                                monthInput.addEventListener(
                                    "input",
                                    inputHandler.bind(undefined, monthMask, 2),
                                    false
                                );

                                var yearMask = ["9999", "9999"];
                                var yearInput = document.querySelector(
                                    "input[name=ano_cartao]"
                                );
                                VMasker(yearInput).maskPattern(yearMask[0]);
                                yearInput.addEventListener(
                                    "input",
                                    inputHandler.bind(undefined, yearMask, 4),
                                    false
                                );

                                var cpfMask = [
                                    "999.999.999-99",
                                    "999.999.999-99"
                                ];
                                var cpfInput = document.querySelector(
                                    "input[name=cpf_cartao]"
                                );
                                VMasker(cpfInput).maskPattern(cpfMask[0]);
                                cpfInput.addEventListener(
                                    "input",
                                    inputHandler.bind(undefined, cpfMask, 14),
                                    false
                                );

                                var birthMask = ["99/99/9999", "99/99/9999"];
                                var birthInput = document.querySelector(
                                    "input[name=birth_cartao]"
                                );
                                VMasker(birthInput).maskPattern(cpfMask[0]);
                                birthInput.addEventListener(
                                    "input",
                                    inputHandler.bind(undefined, birthMask, 10),
                                    false
                                );

                                var celfoneMask = [
                                    "(99) 99999-9999",
                                    "(99) 99999-9999"
                                ];
                                var celfoneCartaoInput = document.querySelector(
                                    "input[name=celfone_cartao]"
                                );
                                VMasker(celfoneCartaoInput).maskPattern(
                                    cpfMask[0]
                                );
                                celfoneCartaoInput.addEventListener(
                                    "input",
                                    inputHandler.bind(
                                        undefined,
                                        celfoneMask,
                                        14
                                    ),
                                    false
                                );

                                //pagseguro events
                                let cardNumber = document.querySelector(
                                    "input[name=numero_cartao]"
                                );
                                let spanBrand = document.querySelector(
                                    "span.brand"
                                );
                                cardNumber.addEventListener(
                                    "keyup",
                                    function() {
                                        if (cardNumber.value.length >= 6) {
                                            PagSeguroDirectPayment.getBrand({
                                                cardBin: cardNumber.value.substr(
                                                    0,
                                                    6
                                                ),
                                                success: function(res) {
                                                    //let imgBrand = `<img src="https://stc.pagseguro.uol.com.br/public/img/payment-methods-flags/68x30/${res.brand.name}.png">`;
                                                    let imgBrand = `<img src="http://127.0.0.1:8000/img/${res.brand.name}.png">`;
                                                    spanBrand.innerHTML = imgBrand;
                                                    document.querySelector(
                                                        "input[name=brand_cartao]"
                                                    ).value = res.brand.name;
                                                    getInstallments(
                                                        totalPayment,
                                                        res.brand.name
                                                    );
                                                },
                                                error: function(err) {
                                                    console.log(err);
                                                },
                                                complete: function(res) {
                                                    console.log(
                                                        "Complete",
                                                        res
                                                    );
                                                }
                                            });
                                        }
                                    }
                                );

                                let submitButton = document.querySelectorAll(
                                    "form.processForm"
                                );
                                submitButton.forEach(function(el, k) {
                                    el.addEventListener("submit", function(
                                        event
                                    ) {
                                        event.preventDefault();
                                        $("#modal").modal("show");
                                        let paymentType =
                                            event.target.dataset.paymentType;
                                        var cpfInput = document.querySelector(
                                            "input[name=cpf_cartao]"
                                        ).value;
                                        var birthInput = document.querySelector(
                                            "input[name=birth_cartao]"
                                        ).value;
                                        var celfoneCartaoInput = document.querySelector(
                                            "input[name=celfone_cartao]"
                                        ).value;
                                        if (paymentType === "creditcard") {
                                            PagSeguroDirectPayment.createCardToken({
                                                cardNumber: document.querySelector(
                                                    "input[name=numero_cartao]"
                                                ).value,
                                                brand: document.querySelector(
                                                    "input[name=brand_cartao]"
                                                ).value,
                                                cvv: document.querySelector(
                                                    "input[name=cvv_cartao]"
                                                ).value,
                                                expirationMonth: document.querySelector(
                                                    "input[name=mes_cartao]"
                                                ).value,
                                                expirationYear: document.querySelector(
                                                    "input[name=ano_cartao]"
                                                ).value,
                                                success: function(res) {
                                                    processPayment(
                                                        res.card.token,
                                                        paymentType,
                                                        cpfInput,
                                                        birthInput,
                                                        celfoneCartaoInput
                                                    );
                                                },
                                                error: function(err) {
                                                    $("#modal").modal(
                                                        "hide"
                                                    );
                                                    window.location.href = `${urlError}`;
                                                },
                                                complete: function(res) {}
                                            });
                                        }
                                        if (paymentType === "boleto") {
                                            processPayment(null, paymentType);
                                        }
                                    });
                                });
                                //pagseguro functions
                                function processPayment(
                                    token,
                                    paymentType,
                                    cpfInput,
                                    birthInput,
                                    celfoneCartaoInput
                                ) {
                                    let data = {
                                        hash: PagSeguroDirectPayment.getSenderHash(),
                                        paymentType: paymentType,
                                        billing: billingValue,
                                        billingAddress: userAddress,
                                        cpfCartao: cpfInput,
                                        birthDate: birthInput,
                                        celfone: celfoneCartaoInput,
                                        _token: csrf
                                    };
                                    if (paymentType == "creditcard") {
                                        //dados cartão de crédito
                                        data.card_token = token;
                                        data.installment = document.querySelector(
                                            "select.select_installments"
                                        ).value;
                                        data.card_name = document.querySelector(
                                            "input[name=nome_cartao]"
                                        ).value;
                                    }
                                    $.ajax({
                                        type: "POST",
                                        url: urlProccess,
                                        data: data,
                                        dataType: "json",
                                        success(res) {
                                            $("#modal").modal("hide");
                                            //toastr.success(res.data.message, 'Sucesso na compra');
                                            window.location.href = `${urlThanks}?pedido='+${res.data.order}`;
                                        },
                                        error: function(err) {
                                            //window.location.href = `${urlError}?codigo=401`;
                                        }
                                    });
                                }

                                function getInstallments(amount, brand) {
                                    PagSeguroDirectPayment.getInstallments({
                                        amount: amount,
                                        brand: brand,
                                        maxInstallmentNoInterest: 0,
                                        success: function(res) {
                                            let selectInstallments = drawSelectInstallments(
                                                res.installments[brand]
                                            );
                                            document.querySelector(
                                                "div.installments"
                                            ).innerHTML = selectInstallments;
                                            console.log(res);
                                        },
                                        complete: function(res) {},
                                        error: function(err) {}
                                    });
                                }

                                function drawSelectInstallments(installments) {
                                    let select =
                                        "<label>Opções de Parcelamento:</label>";
                                    select +=
                                        '<select class="form-control select_installments">';
                                    var formato = {
                                        minimumFractionDigits: 2,
                                        style: "currency",
                                        currency: "BRL"
                                    };
                                    for (let l of installments) {
                                        select += `<option value="${
                                            l.quantity
                                        }|${l.installmentAmount}">${
                                            l.quantity
                                        }x de R$ ${l.installmentAmount.toLocaleString(
                                            "pt-BR",
                                            formato
                                        )} - Total fica R$ ${l.totalAmount.toLocaleString(
                                            "pt-BR",
                                            formato
                                        )}</option>`;
                                    }
                                    select += "</select>";
                                    return select;
                                }
                            }
                        });
                    });
                },

                error: function(err) {
                    console.log(err);
                }
            });
        });
    }
});
