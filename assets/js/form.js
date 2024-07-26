// Verificação do formulário

document.getElementById('submit-button').addEventListener('click', function (event) {
    event.preventDefault(); 

    var formTop = document.getElementById('form-top');
    var formBottom = document.getElementById('form-bottom');

    // Validação dos campos
    var name = document.getElementById('name').value;
    var email = document.getElementById('email').value;
    var phone = document.getElementById('phone').value;
    var address = document.getElementById('address').value;
    var city = document.getElementById('city').value;
    var state = document.getElementById('state').value;
    var resume = document.getElementById('resume').value;
    var attachmentWord = document.getElementById('attachmentWord').files.length;
    var attachmentImg = document.getElementById('attachmentImg').files.length;

    if (name && email && phone && address && city && state && resume && attachmentWord > 0 && attachmentImg > 0) {

        var formData = new FormData(formBottom);

        var attachmentWordInput = document.getElementById('attachmentWord');
        var attachmentImgInput = document.getElementById('attachmentImg');

        if (attachmentWordInput.files.length > 0) {
            formData.append('attachmentWord', attachmentWordInput.files[0]);
        }
        if (attachmentImgInput.files.length > 0) {
            formData.append('attachmentImg', attachmentImgInput.files[0]);
        }
        var request = new XMLHttpRequest();
        request.open('POST', formBottom.action);

        request.onload = function () {
            if (request.status === 200) {
                alert('Formulário enviado com sucesso!');
                formBottom.reset();
                formTop.reset();
            } else {
                alert('Ocorreu um erro ao enviar o formulário. Código de status: ' + request.status);
            }
        };

        request.onerror = function () {
            alert('Erro de rede ou CORS ao enviar o formulário.');
        };

        request.send(formData);
    } else {
        alert('Por favor, preencha todos os campos e anexe todos os arquivos necessários.');
    }
});
