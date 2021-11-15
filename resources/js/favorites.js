function favorite(id, url, token) {
    let data = {
        product: id,
        requestUrl: url,
        _token: token
    };

    $.ajax({
        type: 'POST',
        url: favUrl,
        data: data,
        dataType: 'json',
        success: function(res) {
            if (res.data === 'ok') {
                window.location.reload(false);
                window.location.href = url;
            }
        },
        error: function(err) {
            console.log(err);
        },
        complete: function(res) {
            //console.log(res);
        },
    });
}

function unfavorite(id, url, token) {
    let data = {
        product: id,
        requestUrl: url,
        _token: token
    };

    $.ajax({
        type: 'POST',
        url: unfavUrl,
        data: data,
        dataType: 'json',
        success: function(res) {
            if (res.data === 'ok') {
                window.location.reload(false);
                window.location.href = url;
            }
        },
        error: function(err) {
            console.log(err);
        },
        complete: function(res) {
            //console.log(res);
        },
    });
}