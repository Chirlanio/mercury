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

function previewImagem() {
    var imagem = document.querySelector('input[name=imagem_nova').files[0];
    var preview = document.querySelector('#preview-user');
    var reader = new FileReader();
    reader.onloadend = function () {
        preview.src = reader.result;
    };
    if (imagem) {
        reader.readAsDataURL(imagem);
    } else {
        preview.src = "";
    }
}

function previewImageOne() {
    var imageOne = document.querySelector('input[name=image_one').files[0];
    var preview = document.querySelector('#preview-product-one');
    var reader = new FileReader();
    reader.onloadend = function () {
        preview.src = reader.result;
    };
    if (imageOne) {
        reader.readAsDataURL(imageOne);
    } else {
        preview.src = "";
    }
}

function previewImageTwo() {
    var imageTwo = document.querySelector('input[name=image_two').files[0];
    var preview = document.querySelector('#preview-product-two');
    var reader = new FileReader();
    reader.onloadend = function () {
        preview.src = reader.result;
    };
    if (imageTwo) {
        reader.readAsDataURL(imageTwo);
    } else {
        preview.src = "";
    }
}

function previewImageThree() {
    var imageThree = document.querySelector('input[name=image_three').files[0];
    var preview = document.querySelector('#preview-product-three');
    var reader = new FileReader();
    reader.onloadend = function () {
        preview.src = reader.result;
    };
    if (imageThree) {
        reader.readAsDataURL(imageThree);
    } else {
        preview.src = "";
    }
}

function previewCupom() {
    var imageCupom = document.querySelector('input[name=cupom_fiscal').files[0];
    var preview = document.querySelector('#preview-product-cupom');
    var reader = new FileReader();
    reader.onloadend = function () {
        preview.src = reader.result;
    };
    if (imageCupom) {
        reader.readAsDataURL(imageCupom);
    } else {
        preview.src = "";
    }
}

function previewImageOneNew() {
    var imageOne = document.querySelector('input[name=image_one_new').files[0];
    var preview = document.querySelector('#preview-product-one-new');
    var reader = new FileReader();
    reader.onloadend = function () {
        preview.src = reader.result;
    };
    if (imageOne) {
        reader.readAsDataURL(imageOne);
    } else {
        preview.src = "";
    }
}

function previewImageTwoNew() {
    var imageTwo = document.querySelector('input[name=image_two_new').files[0];
    var preview = document.querySelector('#preview-product-two-new');
    var reader = new FileReader();
    reader.onloadend = function () {
        preview.src = reader.result;
    };
    if (imageTwo) {
        reader.readAsDataURL(imageTwo);
    } else {
        preview.src = "";
    }
}

function previewImageThreeNew() {
    var imageThree = document.querySelector('input[name=image_three_new').files[0];
    var preview = document.querySelector('#preview-product-three-new');
    var reader = new FileReader();
    reader.onloadend = function () {
        preview.src = reader.result;
    };
    if (imageThree) {
        reader.readAsDataURL(imageThree);
    } else {
        preview.src = "";
    }
}

function previewImageCupomNew() {
    var imageCupom = document.querySelector('input[name=cupom_fiscal_new').files[0];
    var preview = document.querySelector('#preview-product-cupom-new');
    var reader = new FileReader();
    reader.onloadend = function () {
        preview.src = reader.result;
    };
    if (imageCupom) {
        reader.readAsDataURL(imageCupom);
    } else {
        preview.src = "";
    }
}

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

var selectType = document.getElementById('adms_type_payment_id');
var div = document.getElementById('parc');
var firstChild = div.children[0];

selectType.addEventListener('change', function () {
    const value = 2;
    if (parseInt(selectType.value) === value) {
        div.classList.remove('d-none');
        div.classList.add('d-flex');
    } else {
        div.classList.remove('d-flex');
        div.classList.add('d-none');
        console.log(div);
    }
});

firstChild.children[1].addEventListener('change', function () {
    var quantidade = firstChild.children[1].value;

    if (quantidade >= 0 || quantidade <= 10) {// Limpa os campos de entrada anteriores
        var camposExistentes = document.querySelectorAll('.input-dinamico');

        camposExistentes.forEach(function (campo) {
            campo.remove();
        });
        // Adiciona novos campos de entrada de acordo com a quantidade
        for (var i = 1; i <= quantidade; i++) {

            var divFormGroup = document.createElement('div');
            divFormGroup.classList.add('form-group', 'col-md-3', 'input-dinamico');
            var label = document.createElement('label');
            label.textContent = 'Valor - Parcela';
            
            var input = document.createElement('input');
            input.setAttribute('name', 'installment_values[]');
            input.setAttribute('type', 'text');
            input.setAttribute('id', 'text');
            input.classList.add('form-control');

            var dateInput = document.createElement('input');
            dateInput.setAttribute('name', 'date_payments[]');
            dateInput.setAttribute('type', 'date');
            dateInput.setAttribute('id', 'dateInput');
            dateInput.classList.add('form-control');

            divFormGroup.appendChild(label);
            divFormGroup.appendChild(input);
            divFormGroup.appendChild(dateInput);
            div.appendChild(divFormGroup);
        }
    }
});