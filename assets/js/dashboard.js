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

//Carregar modal define para Editar
$(document).ready(function () {
    $('a[data-confirm]').click(function (ev) {
        var href = $(this).attr('href');
        if (!$('#confirm-delete').length) {
            $('body').append('<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header bg-danger text-white">EXCLUIR REGISTRO<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body">Tem certeza de que deseja excluir o item selecionado?</div><div class="modal-footer"><button type="button" class="btn btn-success" data-dismiss="modal">Cancelar</button><a class="btn btn-danger text-white" id="dataComfirmOK">Apagar</a></div></div></div></div>');
        }
        $('#dataComfirmOK').attr('href', href);
        $('#confirm-delete').modal({ show: true });
        return false;
    });
});

//Apresentar tooltip
$(function () {
    $('[data-toggle="tooltip"]').tooltip();
});