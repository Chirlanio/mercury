function getValuesFouls() {
    var fouls = document.getElementById('fouls');
    const totalFouls = document.getElementById('totalFouls');
    if (fouls.value === '1') {
        fouls.value = 2;
        totalFouls.removeAttribute('disabled');
        totalFouls.required = true;
    } else {
        fouls.value = 1;
        totalFouls.value = '';
        totalFouls.required = false;
        totalFouls.disabled = true;
        if (totalFouls.value > 0) {
            fouls.checked = true;
        }
    }
}

// adicionar ação ao clique no checkbox
var checkboxesFouls = document.getElementById('fouls');
// somente nome da função, sem executar com ()
checkboxesFouls.addEventListener('click', getValuesFouls, false);

function getValuesDaysOff() {
    var daysOff = document.getElementById('days_off');
    const totalDaysOff = document.getElementById('totalDaysOff');
    if (daysOff.value === '1') {
        daysOff.value = 2;
        totalDaysOff.removeAttribute('disabled');
        totalDaysOff.required = true;
    } else {
        daysOff.value = 1;
        totalDaysOff.value = '';
        totalDaysOff.required = false;
        totalDaysOff.disabled = true;
    }
}

// adicionar ação ao clique no checkbox
var checkboxesDaysOff = document.getElementById('days_off');
// somente nome da função, sem executar com ()
checkboxesDaysOff.addEventListener('click', getValuesDaysOff, false);

function getValuesFolds() {
    var folds = document.getElementById('folds');
    const totalFolds = document.getElementById('totalFolds');
    if (folds.value === '1') {
        folds.value = 2;
        totalFolds.removeAttribute('disabled');
        totalFolds.required = true;
    } else {
        folds.value = 1;
        totalFolds.value = '';
        totalFolds.required = false;
        totalFolds.disabled = true;
    }
}

// adicionar ação ao clique no checkbox
var checkboxesFolds = document.getElementById('folds');
// somente nome da função, sem executar com ()
checkboxesFolds.addEventListener('click', getValuesFolds, false);

function getValuesFixedFund() {
    var fixedFund = document.getElementById('fixed_fund');
    const totalFund = document.getElementById('text1');
    if (fixedFund.value === '1') {
        fixedFund.value = 2;
        totalFund.removeAttribute('disabled');
        totalFund.required = true;
    } else {
        fixedFund.value = 1;
        totalFund.value = '';
        totalFund.required = false;
        totalFund.disabled = true;
    }
}

// adicionar ação ao clique no checkbox
var checkboxesFund = document.getElementById('fixed_fund');
// somente nome da função, sem executar com ()
checkboxesFund.addEventListener('click', getValuesFixedFund, false);

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

function previewNewImage() {
    var imagem = document.querySelector('input[name=new_image').files[0];
    var preview = document.querySelector('#preview-image');
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
