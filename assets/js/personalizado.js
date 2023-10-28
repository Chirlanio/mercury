window.sr = ScrollReveal({
    reset: true
});
sr.reveal('.anima-left', {
    duration: 1000,
    origin: 'left',
    distance: '40px'
});
sr.reveal('.anima-left-delay', {
    duration: 1000,
    origin: 'left',
    distance: '40px',
    delay: 100
});
sr.reveal('.anima-bottom', {
    duration: 1000,
    origin: 'bottom',
    distance: '40px'
});
sr.reveal('.anima-right', {
    duration: 1000,
    origin: 'right',
    distance: '40px'
});
sr.reveal('.anima-right-delay', {
    duration: 1000,
    origin: 'right',
    distance: '40px',
    delay: 100
});
sr.reveal('.anima-top', {
    duration: 1000,
    origin: 'top',
    distance: '40px'
});

//Listar treinamentos
function listar(pagina, varcomp = null) {
    var dados = {
        pagina: pagina
    };
    var endereco = jQuery('.enderecoList').attr('data-enderecoList');
    $.post(endereco + 'escola-digital/listar-videos/' + pagina + '?result=1', dados, function (retorna) {
        $("#conteudo").html(retorna);
    });
}

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

ClassicEditor
        .create(document.querySelector('.editorCK'))
        .catch(error => {
            console.error(error);
        });

ClassicEditor
        .create(document.querySelector('.editorCKQl'))
        .catch(error => {
            console.error(error);
        });

ClassicEditor
        .create(document.querySelector('.editorObs'))
        .catch(error => {
            console.error(error);
        });

ClassicEditor
        .create(document.querySelector('.editorFarUm'))
        .catch(error => {
            console.error(error);
        });

ClassicEditor
        .create(document.querySelector('.editorFarDois'))
        .catch(error => {
            console.error(error);
        });

ClassicEditor
        .create(document.querySelector('.editorMatUm'))
        .catch(error => {
            console.error(error);
        });

ClassicEditor
        .create(document.querySelector('.editorMatDois'))
        .catch(error => {
            console.error(error);
        });

ClassicEditor
        .create(document.querySelector('.editorDesUm'))
        .catch(error => {
            console.error(error);
        });

ClassicEditor
        .create(document.querySelector('.editorDesDois'))
        .catch(error => {
            console.error(error);
        });

$(document).ready(function () {
    $('#date').mask('00/00/0000');
    $('#time').mask('00:00:00');
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
    $('#cost_center_id').mask("0.0.0.00.#0000", {reverse: false});
    $('.cost_center').mask("0.0.0.00.#0000", {reverse: false});
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

function valorEstorno() {
    var valorLancado = document.querySelector('#valor_lancado').value;
    var valorCorreto = document.querySelector('#valor_correto').value;

    var valorEstorno = parseFloat(valorLancado) - parseFloat(valorCorreto);

    console.log(valorEstorno);
}

function somaTotalRefAjuste() {

    var total = 0;

    var t01 = Number(document.getElementById('t01').value);
    var t33 = Number(document.getElementById('t33').value);
    var t34 = Number(document.getElementById('t34').value);
    var t35 = Number(document.getElementById('t35').value);
    var t36 = Number(document.getElementById('t36').value);
    var t37 = Number(document.getElementById('t37').value);
    var t38 = Number(document.getElementById('t38').value);
    var t39 = Number(document.getElementById('t39').value);
    var t40 = Number(document.getElementById('t40').value);

    total = t01 + t33 + t34 + t35 + t36 + t37 + t38 + t39 + t40;

    var element = document.querySelector('span[name="total"]');
    if (element.textContent === undefined) {
        element.value = 0;
    } else {
        element.value = total;
    }
    element.innerHTML = '<input name="total" class="form-control text-center" id="total" value=' + total + ' readonly tabindex="9999">';
}

function somaTotalRefAjusteSecond() {

    var total = 0;

    var t01 = Number(document.getElementById('t01_2').value);
    var t33 = Number(document.getElementById('t33_2').value);
    var t34 = Number(document.getElementById('t34_2').value);
    var t35 = Number(document.getElementById('t35_2').value);
    var t36 = Number(document.getElementById('t36_2').value);
    var t37 = Number(document.getElementById('t37_2').value);
    var t38 = Number(document.getElementById('t38_2').value);
    var t39 = Number(document.getElementById('t39_2').value);
    var t40 = Number(document.getElementById('t40_2').value);

    total = t01 + t33 + t34 + t35 + t36 + t37 + t38 + t39 + t40;

    var element = document.querySelector('span[name="total2"]');
    if (element.textContent === undefined) {
        element.value = 0;
    } else {
        element.value = total;
    }
    element.innerHTML = '<input name="total_2" class="form-control text-center" id="total2" value=' + total + ' readonly tabindex="9998">';
}

function somaTotalRefAjusteThird() {

    var total = 0;

    var t01 = Number(document.getElementById('t01_3').value);
    var t33 = Number(document.getElementById('t33_3').value);
    var t34 = Number(document.getElementById('t34_3').value);
    var t35 = Number(document.getElementById('t35_3').value);
    var t36 = Number(document.getElementById('t36_3').value);
    var t37 = Number(document.getElementById('t37_3').value);
    var t38 = Number(document.getElementById('t38_3').value);
    var t39 = Number(document.getElementById('t39_3').value);
    var t40 = Number(document.getElementById('t40_3').value);

    total = t01 + t33 + t34 + t35 + t36 + t37 + t38 + t39 + t40;

    var element = document.querySelector('span[name="total3"]');
    if (element.textContent === undefined) {
        element.value = 0;
    } else {
        element.value = total;
    }
    element.innerHTML = '<input name="total_3" class="form-control text-center" id="total3" value=' + total + ' readonly tabindex="9997">';
}

function somaTotalRefAjusteFourth() {

    var total = 0;

    var t01 = Number(document.getElementById('t01_4').value);
    var t33 = Number(document.getElementById('t33_4').value);
    var t34 = Number(document.getElementById('t34_4').value);
    var t35 = Number(document.getElementById('t35_4').value);
    var t36 = Number(document.getElementById('t36_4').value);
    var t37 = Number(document.getElementById('t37_4').value);
    var t38 = Number(document.getElementById('t38_4').value);
    var t39 = Number(document.getElementById('t39_4').value);
    var t40 = Number(document.getElementById('t40_4').value);

    total = t01 + t33 + t34 + t35 + t36 + t37 + t38 + t39 + t40;

    var element = document.querySelector('span[name="total4"]');
    if (element.textContent === undefined) {
        element.value = 0;
    } else {
        element.value = total;
    }
    element.innerHTML = '<input name="total_4" class="form-control text-center" id="total4" value=' + total + ' readonly tabindex="9996">';
}

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
