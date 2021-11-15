function alterPagseguroStatus(id, token, value) {
    var confirm = window.confirm("Tem certeza da sua alteração do pagamento?");
    if (confirm == true) {
        let data = {
            id: id,
            _token: token,
            value: value
        };

        $.ajax({
            type: 'POST',
            url: cfsaUrl,
            data: data,
            dataType: 'json',
            success(res) {
                alert("Alteração na transação código: " + res.data.codigo + " feita com sucesso.");
                document.location.reload();
            },
            error: function(err) {
                console.log(err);
            }

        });
    } else {
        alert("Alteração cancelada");
        let pagseguroStatusRadios = document.querySelectorAll('input[name=pagseguroStatusInputs');
        for (var i = 0, l = pagseguroStatusRadios.length; i < l; i++) {
            pagseguroStatusRadios[i].checked = false;
        }
    }
};