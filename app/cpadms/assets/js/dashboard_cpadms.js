$(document).ready(function () {
    var pagina = 1; //página inicial
    listar(pagina);
});

//Listar usuários
function listar(pagina, varcomp = null) {
    var dados = {
        pagina: pagina
    };
    var endereco = jQuery('.enderecoList').attr('data-enderecoList');
    $.post(endereco + 'carregar-usuarios-js/listar/' + pagina + '?tiporesult=1', dados, function (retorna) {
        $("#conteudo").html(retorna);
    });
}

//Pesuisar usuários
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
            listar(pagina);
        }
    });
});

//Ver detalhes dos usuários
$(document).ready(function () {
    $(document).on('click', '.view_data', function () {
        var user_id = $(this).attr('id');

        if (user_id !== '') {
            var dados = {
                user_id: user_id
            };
            var endereco = jQuery('.endereco').attr('data-endereco');
            $.post(endereco + 'ver-usuario-modal/ver-usuario/' + user_id, dados, function (retorna) {
                $('#visul_usuario').html(retorna);
                $('#visulUsuarioModal').modal('show');
            });
        }
    });
});

//Editar cadastro dos usuários
$(document).ready(function () {
    $(document).on('click', '.view_data_edit', function () {
        var id = $(this).attr('id');
        if (id !== '') {
            var dados = {
                id
            };
            console.log(dados);
            var enderecoEdit = jQuery('.enderecoedit').attr('data-enderecoedit');
            $.post(enderecoEdit + 'editar-usuario-modal/edit-usuario/' + id, dados, function (retorna) {
                $('#edit_usuario').html(retorna);
                $('#editUsuarioModal').modal('show');
            });
        }
    });
});

$("#edit_form").on("submit", function (event) {
    event.preventDefault();

    var enderecoedit = jQuery('.enderecoedit').attr("data-enderecoedit");
    $.ajax({
        method: "POST",
        url: enderecoedit,
        data: new FormData(this),
        contentType: false,
        processData: false,
        success: function (retorna) {
            if (retorna['erro']) {
                //$('#msgCad').html(retorna['msg']);
                $('.addModal').modal('hide');
                $('#addSucessoModal').modal('show');
                listar(1);
            } else {
                $('#msgEdit').html(retorna['msg']);
            }
        }
    });
});

//Cadastrar usuários
$("#insert_form").on("submit", function (event) {
    event.preventDefault();

    var enderecocad = jQuery('.enderecocad').attr("data-enderecocad");
    $.ajax({
        method: "POST",
        url: enderecocad,
        data: new FormData(this),
        contentType: false,
        processData: false,
        success: function (retorna) {
            if (retorna['erro']) {
                //$('#msgCad').html(retorna['msg']);
                $('.addModal').modal('hide');
                $('#addSucessoModal').modal('show');
                listar(1);
            } else {
                $('#msgCad').html(retorna['msg']);
            }
        }
    });
});