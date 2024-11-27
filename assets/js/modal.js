// Interceptar o envio do formulário
document.getElementById("login-form").addEventListener("submit", function (e) {
    e.preventDefault(); // Impede o envio padrão do formulário

    // Coleta os dados do formulário
    const formData = new FormData(this);

    // Envia a requisição AJAX
    fetch("../php/cadastrar_cliente.php", {
        method: "POST",
        body: formData,
    })
        .then(response => response.text())
        .then(responseText => {
            if (responseText.includes("Cadastro realizado com sucesso")) {
                // Exibe o modal de sucesso
                const modal = document.getElementById("success-modal");
                modal.style.display = "flex"; // Mostra o modal (flex para centralizar)

                // Adiciona evento ao botão de login
                document.getElementById("btn-login").onclick = () => {
                    window.location.href = "../html/login.php";
                };
            } else {
                alert(responseText); // Mostra mensagem de erro caso ocorra
            }
        })
        .catch(error => console.error("Erro:", error));

    // Adiciona evento ao botão de login dentro do bloco de sucesso
    document.getElementById("btn-login").addEventListener("click", function () {
        console.log("Botão de login clicado."); // Verificação no console
        window.location.href = "../html/login.php"; // Redireciona para a página de login
    });

});

// Evento para fechar o modal ao clicar no "X"
document.getElementById("close-modal").addEventListener("click", function () {
    const modal = document.getElementById("success-modal");
    modal.style.display = "none"; // Esconde o modal
});