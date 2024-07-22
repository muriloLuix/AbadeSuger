document.getElementById('submit-button').addEventListener('click', function() {
    var formTop = document.getElementById('form-top');
    var formBottom = document.getElementById('form-bottom');

    // Criar um FormData para o formulário de envio
    var formData = new FormData(formBottom);

    // Adicionar os arquivos do formulário do topo
    var attachmentWord = document.getElementById('attachmentWord');
    var attachmentImg = document.getElementById('attachmentImg');

    if (attachmentWord.files.length > 0) {
        formData.append('attachmentWord', attachmentWord.files[0]);
    }
    if (attachmentImg.files.length > 0) {
        formData.append('attachmentImg', attachmentImg.files[0]);
    }

    // Submeter o formulário usando XMLHttpRequest
    var request = new XMLHttpRequest();
    request.open('POST', formBottom.action);

    request.onload = function() {
        if (request.status === 200) {
            alert('Formulário enviado com sucesso!');
        } else {
            alert('Ocorreu um erro ao enviar o formulário. Código de status: ' + request.status);
        }
    };

    request.onerror = function() {
        alert('Erro de rede ou CORS ao enviar o formulário.');
    };

    request.send(formData);
});
