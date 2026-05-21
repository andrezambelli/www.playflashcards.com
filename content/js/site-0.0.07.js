$(document).ready(function() {
    $('#btn_menu_div').click(function(event) {
        if ($('#menu_div').is(":visible")) {
            $('#menu_div').hide();
            $('#menu_img').show();
            $('#close_img').hide();
        } else {
            $('#menu_div').show();
            $('#menu_img').hide();
            $('#close_img').show();
        }
    });
});

/**
 * Recebe um número e adiciona 0 se for menor que 10
 */
function padZero(_value) {
    return _value < 10 ? "0" + _value : _value;
}

/**
 * Pega o timezone do navegador, formata e devolve no formato utilizado para o banco de dados
 * Por exemplo: -03:00
 */
function getTimezoneFormated() {
    var result = "+00:00"; // GMT-0

    var offset = new Date().getTimezoneOffset();
    var hours = Math.floor(Math.abs(offset) / 60);
    var minutes = Math.abs(offset) % 60;
    var sign = offset < 0 ? "+" : "-";

    result = sign + padZero(hours) + ":" + padZero(minutes);

    return result;
}

/**
 * Aceite dos Cookies
 */
function setCookieGDPR(_url) {
    $('.div-cookie-consent').hide();

    if (_url != null) {
        $.ajax({
            url: _url,
            type: "POST",
            success: function (response) {
            },
            error: function (xhr, status, error) {
            }
        });
    }
}