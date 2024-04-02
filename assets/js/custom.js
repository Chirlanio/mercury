/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/javascript.js to edit this template
 */

const btnSave = document.querySelector('input[type=submit]');

btnSave.addEventListener('click', function(e) {
    e.preventDefaut();
    window.alert('Salvando...');
    console.log(btnSave);
});

var selectType = document.getElementById('adms_type_payment_id');
var div = document.getElementById('parc');
var firstChild = div.children[0];

selectType.addEventListener('change', function () {
    const value = 5;
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
            label.setAttribute('for', 'text' + i);
            label.textContent = 'Valor - Parcela';

            var input = document.createElement('input');
            input.setAttribute('name', 'installment_values[]');
            input.setAttribute('type', 'text');
            input.setAttribute('id', 'text' + i);
            input.classList.add('form-control');
            input.classList.add('mb-1');

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