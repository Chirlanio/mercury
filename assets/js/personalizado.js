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

ClassicEditor.create(document.querySelector('#editor'), {

    toolbar: {
        items: [
            'heading',
            '|',
            'undo',
            'redo',
            '|',
            'fontSize',
            'fontColor',
            'fontFamily',
            'fontBackgroundColor',
            '|',
            'bold',
            'italic',
            'underline',
            'highlight',
            '|',
            'link',
            'bulletedList',
            'numberedList',
            '|',
            'alignment',
            'outdent',
            'indent',
            '|',
            'blockQuote'
        ]
    },
    language: 'pt-br',
    licenseKey: ''

}).then(editor => {
    window.editor = editor;








}).catch(error => {
    console.error('Oops, something went wrong!');
    console.error('Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:');
    console.warn('Build id: ft5srbo8lapj-rvz0q0dptoyp');
    console.error(error);
});

ClassicEditor.create(document.querySelector('#editor-um'), {

    toolbar: {
        items: [
            'heading',
            '|',
            'undo',
            'redo',
            '|',
            'fontSize',
            'fontColor',
            'fontFamily',
            'fontBackgroundColor',
            '|',
            'bold',
            'italic',
            'underline',
            'highlight',
            '|',
            'link',
            'bulletedList',
            'numberedList',
            '|',
            'alignment',
            'outdent',
            'indent',
            '|',
            'blockQuote'
        ]
    },
    language: 'pt-br',
    licenseKey: ''

}).then(editor => {
    window.editor = editor;








}).catch(error => {
    console.error('Oops, something went wrong!');
    console.error('Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:');
    console.warn('Build id: ft5srbo8lapj-rvz0q0dptoyp');
    console.error(error);
});

ClassicEditor.create(document.querySelector('#editor-dois'), {

    toolbar: {
        items: [
            'heading',
            '|',
            'undo',
            'redo',
            '|',
            'fontSize',
            'fontColor',
            'fontFamily',
            'fontBackgroundColor',
            '|',
            'bold',
            'italic',
            'underline',
            'highlight',
            '|',
            'link',
            'bulletedList',
            'numberedList',
            '|',
            'alignment',
            'outdent',
            'indent',
            '|',
            'blockQuote'
        ]
    },
    language: 'pt-br',
    licenseKey: ''

}).then(editor => {
    window.editor = editor;








}).catch(error => {
    console.error('Oops, something went wrong!');
    console.error('Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:');
    console.warn('Build id: ft5srbo8lapj-rvz0q0dptoyp');
    console.error(error);
});

ClassicEditor.create(document.querySelector('#editor-tres'), {

    toolbar: {
        items: [
            'heading',
            '|',
            'undo',
            'redo',
            '|',
            'fontSize',
            'fontColor',
            'fontFamily',
            'fontBackgroundColor',
            '|',
            'bold',
            'italic',
            'underline',
            'highlight',
            '|',
            'link',
            'bulletedList',
            'numberedList',
            '|',
            'alignment',
            'outdent',
            'indent',
            '|',
            'blockQuote'
        ]
    },
    language: 'pt-br',
    licenseKey: ''

}).then(editor => {
    window.editor = editor;








}).catch(error => {
    console.error('Oops, something went wrong!');
    console.error('Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:');
    console.warn('Build id: ft5srbo8lapj-rvz0q0dptoyp');
    console.error(error);
});

$(document).ready(function(){
  $('#date').mask('00/00/0000');
  $('#time').mask('00:00:00');
  $('#date_time').mask('00/00/0000 00:00:00');
  $('#cep').mask('00000-000');
  $('#phone').mask('00000-0000');
  $('#phone_with_ddd').mask('(00) 00000-0000');
  $('#phone_us').mask('(000) 000-0000');
  $('#mixed').mask('AAA 000-S0S');
  $('#cpf').mask('000.000.000-00', {reverse: true});
  $('#cnpj').mask('00.000.000/0000-00', {reverse: true});
  $('#money').mask('000.000.000.000.000,00', {reverse: true});
  $('#valor_lancado').mask("#.##0,00", {reverse: true});
  $('#valor_correto').mask("#.##0,00", {reverse: true});
  $('#valor_estorno').mask("#.##0,00", {reverse: true});
  $('#ip_address').mask('0ZZ.0ZZ.0ZZ.0ZZ', {
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

function valorEstorno (){
    var valorLancado = document.querySelector('#valor_lancado').value;
    var valorCorreto = document.querySelector('#valor_correto').value;
    
    var valorEstorno = parseFloat(valorLancado) - parseFloat(valorCorreto);
    
    console.log(valorEstorno);
}

