document.getElementById('login-form').addEventListener('submit', function (event) {
    event.preventDefault(); // Previne o comportamento padrão do formulário

    const cli_login = document.getElementById('cli_login').value;
    const cli_senha = document.getElementById('cli_senha').value;

    fetch('../php/login.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({ cli_login, cli_senha }),
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Exibe modal de sucesso
                const modalSucesso = document.getElementById('modal-sucesso');
                modalSucesso.style.display = 'flex';

                // Configura o redirecionamento após o clique no botão "OK"
                document.getElementById('btn-ok-sucesso').onclick = () => {
                    window.location.href = data.redirect;
                };
            } else {
                // Exibe modal de erro
                const modalErro = document.getElementById('modal-erro');
                modalErro.style.display = 'flex';
                document.getElementById('erro-msg').innerText = data.message;
            }
        })
        .catch(error => {
            console.error('Erro na requisição:', error);
        });
});

function fecharModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}
