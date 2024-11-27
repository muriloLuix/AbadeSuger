(() => {
    const modalExcluirLivro = document.getElementById('modalExcluirLivro');
    const closeExcluirLivro = document.getElementById('closeExcluirLivro');
    const cancelExcluirLivro = document.getElementById('cancelExcluirLivro');
    const formExcluirLivro = document.getElementById('formExcluirLivro');

    // Abrir o modal de exclusão ao clicar no botão "Excluir"
    document.addEventListener('click', (event) => {
        if (event.target.classList.contains('btn-excluir-livro')) {
            const livId = event.target.getAttribute('data-id');

            // Define o ID do livro no input oculto
            document.getElementById('delete_liv_id').value = livId;

            // Abre o modal
            modalExcluirLivro.style.display = 'block';
        }
    });

    // Fechar o modal ao clicar no botão "X"
    closeExcluirLivro.onclick = () => {
        modalExcluirLivro.style.display = 'none';
    };

    // Cancelar exclusão ao clicar no botão "Cancelar"
    cancelExcluirLivro.onclick = () => {
        modalExcluirLivro.style.display = 'none';
    };

    // Submeter o formulário de exclusão via AJAX
    formExcluirLivro.onsubmit = async (event) => {
        event.preventDefault();

        const formData = new FormData(formExcluirLivro);

        try {
            const response = await fetch('../php/excluir_livro.php', {
                method: 'POST',
                body: formData,
            });

            const result = await response.json();

            if (result.success) {
                alert('Livro excluído com sucesso!');

                // Remove a linha correspondente da tabela
                const livId = formData.get('liv_id');
                const row = document.querySelector(`tr[data-id="${livId}"]`);
                if (row) row.remove();

                // Fecha o modal
                modalExcluirLivro.style.display = 'none';
            } else {
                alert('Erro ao excluir o livro: ' + result.message);
            }
        } catch (error) {
            alert('Erro ao enviar a solicitação: ' + error.message);
        }
    };
})();


// Seleção dos elementos do modal
const openModalButton = document.getElementById('openModalButton');
const cadastrarLivroModal = document.getElementById('cadastrarLivroModal');
const closeModalButton = document.querySelector('.close-button');

// Função para abrir o modal
openModalButton.addEventListener('click', () => {
    cadastrarLivroModal.style.display = 'block'; // Exibe o modal
});

// Função para fechar o modal ao clicar no botão "X"
closeModalButton.addEventListener('click', () => {
    cadastrarLivroModal.style.display = 'none'; // Esconde o modal
});

// Função para fechar o modal ao clicar fora do conteúdo
window.addEventListener('click', (event) => {
    if (event.target === cadastrarLivroModal) {
        cadastrarLivroModal.style.display = 'none'; // Esconde o modal
    }
});
