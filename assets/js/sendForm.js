form.addEventListener('submit', function (event) {
    event.preventDefault(); // Impede o envio normal do formulário

    const formData = new FormData(form);

    fetch('../php/cadastrar_cliente.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.text())
        .then(data => {
            console.log("Resposta do servidor:", data); // Verifique a resposta do servidor
            if (data.trim() === "Cadastro realizado com sucesso!") {
                document.getElementById("successModal").style.display = "flex"; // Mostrar o modal
            }
        })
        .catch(error => {
            console.error('Erro ao enviar os dados:', error);
        });
});
