// Verificação do formulário


document.getElementById('submit-button').addEventListener('click', function (event) {
    event.preventDefault();

    var formTop = document.getElementById('form-top');
    var formBottom = document.getElementById('form-bottom');

    // Validação dos campos
    var title = document.getElementById('title').value;
    var author = document.getElementById('author').value;
    var company = document.getElementById('company').value;
    var address = document.getElementById('address').value;
    var city = document.getElementById('city').value;
    var resume = document.getElementById('resume').value;
    var cellphone = document.getElementById('cellphone').value;
    var attachmentWord = document.getElementById('attachmentWord').files.length;

    // Checa se todos os campos obrigatórios estão preenchidos
    if (title && author && company && address && city && resume && cellphone && attachmentWord > 0) {

        var formData = new FormData(formBottom);

        var attachmentWordInput = document.getElementById('attachmentWord');

        if (attachmentWordInput.files.length > 0) {
            formData.append('attachmentWord', attachmentWordInput.files[0]);
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
