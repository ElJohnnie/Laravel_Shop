/* JS Document */

function deleteAddress(id, token, deleteAddressUrl) {
    let dados = {
        id: id,
        _token: token
    };
    $.ajax({
        type: "POST",
        url: deleteAddressUrl,
        data: dados,
        dataType: "json",
        success(res) {
            if (res.data.status == true) {
                sessionStorage.setItem(res.data.status, res.data.message);
                window.location.reload(false);
            }
        },
        error: function(err) {
            console.log(err);
        }
    });
}
