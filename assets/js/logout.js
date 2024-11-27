// Seleciona os elementos do DOM
const logoutButton = document.getElementById('logoutButton');
const logoutModal = document.getElementById('logoutModal');
const confirmLogout = document.getElementById('confirmLogout');
const cancelLogout = document.getElementById('cancelLogout');

// Exibe o modal quando o botão de logout for clicado
logoutButton.addEventListener('click', () => {
    logoutModal.style.display = 'flex';
});

// Fecha o modal ao clicar em "Cancelar"
cancelLogout.addEventListener('click', () => {
    logoutModal.style.display = 'none';
});

// Redireciona para o logout.php ao clicar em "Sair"
confirmLogout.addEventListener('click', () => {
    window.location.href = '../php/logout.php';
});


// Elementos do modal
const editButton = document.querySelector('.button button'); // Botão de editar
const editModal = document.getElementById('editModal'); // Modal de edição
const cancelEdit = document.getElementById('cancelEdit'); // Botão de cancelar

// Exibe o modal ao clicar no botão de editar
editButton.addEventListener('click', () => {
    editModal.style.display = 'flex';
});

// Fecha o modal ao clicar no botão de cancelar
cancelEdit.addEventListener('click', () => {
    editModal.style.display = 'none';
});


// Seleciona o formulário e o modal
const editForm = document.getElementById('edit-form');

// Adiciona o evento de envio no formulário
editForm.addEventListener('submit', function (e) {
    e.preventDefault(); // Impede o envio padrão do formulário

    // Cria um objeto FormData com os dados do formulário
    const formData = new FormData(editForm);

    // Envia a requisição via AJAX
    fetch('../php/editar_cliente.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // Exibe um alert de sucesso
                alert(data.message);

                // Fecha o modal
                editModal.style.display = 'none';

                // Opcional: Atualize os campos na página com os novos valores
                document.querySelector('.nomeUsu p').textContent = formData.get('cli_nome');
                document.querySelector('.sobrenomeUsu p').textContent = formData.get('cli_sobrenome');
                document.querySelector('.email p').textContent = formData.get('cli_email');
                document.querySelector('.telefone p').textContent = formData.get('cli_telefone');
                document.querySelector('.endereco p').textContent =
                    `${formData.get('cli_rua')}, ${formData.get('cli_numero')}, ${formData.get('cli_complemento') || ''}, ${formData.get('cli_bairro')}, ${formData.get('cli_cidade')}`;
            } else {
                // Exibe um alert de erro
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Ocorreu um erro ao atualizar as informações.');
        });
});
