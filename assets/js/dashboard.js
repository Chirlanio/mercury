$(document).ready(function () {
    //Apresentar ou ocultar o menu
    $('.sidebar-toggle').on('click', function () {
        $('.sidebar').toggleClass('toggled');
    });
    //carregar aberto o submenu
    var active = $('.sidebar .active');
    if (active.length && active.parent('.collapse').length) {
        var parent = active.parent('.collapse');
        parent.prev('a').attr('aria-expanded', true);
        parent.addClass('show');
    }
});

//Pesquisar treinamentos
$(function () {
    $("#pesqVideo").keyup(function () {
        var pesqVideo = $(this).val();
        console.log(pesqVideo);

        if (pesqVideo !== '') {
            var dados = {
                palavraPesq: pesqVideo
            };
            $.post('../escola-digital/listar-videos/1?result=2', dados, function (retorna) {
                $("#conteudo").html(retorna);
            });
        } else {
            var pagina = 1;
            listar(pagina);
        }
    });
});

var ClassicEditor;

$(document).ready(function () {
    if (editorCK.classList.contains('editorCK')) {
        ClassicEditor
                .create(document.querySelector('.editorCK'))
                .catch(error => {
                    console.error(error);
                });
    }
});

$(document).ready(function () {
    if (editorCKQl.classList.contains('editorCKQl')) {
        ClassicEditor
                .create(document.getElementById('editorCKQl'))
                .catch(error => {
                    console.error(error);
                });
    }
});

$(document).ready(function () {
    if (editorObs.classList.contains('editorObs')) {
        ClassicEditor
                .create(document.querySelector('.editorObs'))
                .catch(error => {
                    console.error(error);
                });
    }
});

$(document).ready(function () {
    if (editorFarUm.classList.contains('editorFarUm')) {
        ClassicEditor
                .create(document.querySelector('.editorFarUm'))
                .catch(error => {
                    console.error(error);
                });
    }
});

$(document).ready(function () {
    if (editorFarDois.classList.contains('editorFarDois')) {
        ClassicEditor
                .create(document.querySelector('.editorFarDois'))
                .catch(error => {
                    console.error(error);
                });
    }
});

$(document).ready(function () {
    if (editorMatUm.classList.contains('editorMatUm')) {
        ClassicEditor
                .create(document.querySelector('.editorMatUm'))
                .catch(error => {
                    console.error(error);
                });
    }
});

$(document).ready(function () {
    if (editorMatDois.classList.contains('editorMatDois')) {
        ClassicEditor
                .create(document.querySelector('.editorMatDois'))
                .catch(error => {
                    console.error(error);
                });
    }
});

$(document).ready(function () {
    if (editorDesUm.classList.contains('editorDesUm')) {
        ClassicEditor
                .create(document.querySelector('.editorDesUm'))
                .catch(error => {
                    console.error(error);
                });
    }
});

$(document).ready(function () {
    if (editorDesDois.classList.contains('editorDesDois')) {
        ClassicEditor
                .create(document.querySelector('.editorDesDois'))
                .catch(error => {
                    console.error(error);
                });
    }
});

$(document).ready(function () {
    $('#date').mask('00/00/0000');
    $('#time').mask('00:00:00');
    $('#totalFolds').mask('00:00:00', {reverse: true});
    $('#date_time').mask('00/00/0000 00:00:00');
    $('#cep').mask('00000-000');
    $('#phone').mask('00000-0000');
    $('#order_service_zznet').mask('######-00000');
    $('#phone_with_ddd').mask('(00) 00000-0000');
    $('#phone_us').mask('(000) 000-0000');
    $('#mixed').mask('AAA 000-S0S');
    $('#cpf').mask('000.000.000-00', {reverse: true});
    $('#cnpj').mask('00.000.000/0000-00', {reverse: true});
    $('#inscricao_estadual').mask('00.000000-0', {reverse: true});
    $('#money').mask('000.000.000.000.000,00', {reverse: true});
    $('#valor_lancado').mask("#.##0,00", {reverse: true});
    $('#valor_venda').mask("#.##0,00", {reverse: true});
    $('#valor_correto').mask("#.##0,00", {reverse: true});
    $('#valor_estorno').mask("#.##0,00", {reverse: true});
    $('#text1').mask("#.##0,00", {reverse: true});
    $('#text2').mask("#.##0,00", {reverse: true});
    $('#cost_center_id').mask("0.0.00.00", {reverse: false});
    $('.cost_center').mask("0.0.00.00", {reverse: false});
    $('#version_number').mask("0.0.0.00", {reverse: false});
    $('#ip_address').mask('0ZZ.0ZZ.0ZZ.0ZZ', {
        translation: {
            'Z': {
                pattern: /[0-9]/, optional: true
            }
        }
    });
    $('#installments').mask('ZZ', {
        translation: {
            'Z': {
                pattern: /[0-9]/, optional: true
            }
        }
    });
    $('#ip_address').mask('099.099.099.099');
    $('#percent').mask('##0,00%', {reverse: true});
    $('#clear-if-not-match').mask("00/00/0000", {clearIfNotMatch: true});
    $('#placeholder').mask("00/00/0000", {placeholder: "__/__/____"});
    $('#cnpj_cpf').mask("00.000.000/0000-00", {placeholder: "00.000.000/0000-00"});
    $('#document_number_supplier').mask("000.000.000-00", {placeholder: "000.000.000-00"});
    $('#contact').mask("(00) 00000-0000", {placeholder: "(00) 00000-0000"});
    $('#fallback').mask("00r00r0000", {
        translation: {
            'r': {
                pattern: /[\/]/,
                fallback: '/'
            },
            placeholder: "__/__/____"
        }
    });
    $('.selectonfocus').mask("00/00/0000", {selectOnFocus: true});
});

$(document).change(function () {
    $('#text1').mask("#.##0,00", {reverse: true});
    $('#text2').mask("#.##0,00", {reverse: true});
    $('#text3').mask("#.##0,00", {reverse: true});
    $('#text4').mask("#.##0,00", {reverse: true});
    $('#text5').mask("#.##0,00", {reverse: true});
    $('#text6').mask("#.##0,00", {reverse: true});
    $('#text7').mask("#.##0,00", {reverse: true});
    $('#text8').mask("#.##0,00", {reverse: true});
    $('#text9').mask("#.##0,00", {reverse: true});
    $('#text10').mask("#.##0,00", {reverse: true});
});

$(document).ready(function () {
    $('a[data-toggle]').click(function (ev) {
        var href = $(this).attr('href');
        if (!$('#exampleModal').length) {
            $('body').append('<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="exampleModalLabel">Modal title</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body">...</div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button><button type="button" class="btn btn-primary">Save changes</button></div></div></div></div>');
        }
        $('#dataEditOk').attr('href', href);
        $('#confirm-edit').modal({show: true});
    });
});

//Carregar modal define para Editar
$(document).ready(function () {
    $('a[data-confirm]').click(function (ev) {
        var href = $(this).attr('href');
        if (!$('#confirm-delete').length) {
            $('body').append('<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header bg-danger text-white">EXCLUIR REGISTRO<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body">Tem certeza de que deseja excluir o item selecionado?</div><div class="modal-footer"><button type="button" class="btn btn-success" data-dismiss="modal">Cancelar</button><a class="btn btn-danger text-white" id="dataComfirmOK">Apagar</a></div></div></div></div>');
        }
        $('#dataComfirmOK').attr('href', href);
        $('#confirm-delete').modal({show: true});
        return false;
    });
});

//Apresentar tooltip
$(function () {
    $('[data-toggle="tooltip"]').tooltip();
});

