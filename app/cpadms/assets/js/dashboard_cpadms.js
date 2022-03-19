$(document).ready(function () {
    var pagina = 1; //página inicial
    listar_usuario(pagina);
});

function listar_usuario(pagina, varcomp = null) {
    var dados = {
        pagina: pagina
    };
    $.post('../carregar-usuarios-js/listar/' + pagina + '?tiporesult=1', dados, function (retorna) {
        $("#conteudo").html(retorna);
    });
}

$(function () {
    $("#pesqUser").keyup(function () {
        var pesqUser = $(this).val();

        if (pesqUser !== '') {
            var dados = {
                palavraPesq: pesqUser
            };
            $.post('../carregar-usuarios-js/listar/1?tiporesult=2', dados, function (retorna) {
                $("#conteudo").html(retorna);
            });
        } else {
            var pagina = 1;
            listar_usuario(pagina);
        }
    });
});