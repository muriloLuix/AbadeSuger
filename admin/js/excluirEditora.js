(() => {
    const modalExcluirEditora = document.getElementById('modalExcluirEditora');
    const closeExcluirEditora = document.getElementById('closeExcluirEditora');
    const cancelExcluirEditora = document.getElementById('cancelExcluirEditora');
    const formExcluirEditora = document.getElementById('formExcluirEditora');

    // Abrir o modal de exclusão ao clicar no botão "Excluir"
    document.addEventListener('click', (event) => {
        if (event.target.classList.contains('btn-excluir-editora')) {
            const ediId = event.target.getAttribute('data-id');

            // Define o ID da editora no input oculto
            document.getElementById('delete_edi_id').value = ediId;

            // Abre o modal
            modalExcluirEditora.style.display = 'block';
        }
    });

    // Fechar o modal ao clicar no botão "X"
    closeExcluirEditora.onclick = () => {
        modalExcluirEditora.style.display = 'none';
    };

    // Cancelar exclusão ao clicar no botão "Cancelar"
    cancelExcluirEditora.onclick = () => {
        modalExcluirEditora.style.display = 'none';
    };

    // Submeter o formulário de exclusão via AJAX
    formExcluirEditora.onsubmit = async (event) => {
        event.preventDefault();

        const formData = new FormData(formExcluirEditora);

        try {
            const response = await fetch('../php/excluir_editora.php', {
                method: 'POST',
                body: formData,
            });

            const result = await response.text();

            if (result.trim() === 'success') {
                alert('Editora excluída com sucesso!');

                // Remove a linha correspondente da tabela
                const ediId = formData.get('edi_id');
                const row = document.querySelector(`tr[data-id="${ediId}"]`);
                row.remove();

                // Fecha o modal
                modalExcluirEditora.style.display = 'none';
            } else {
                alert('Erro ao excluir a editora: ' + result);
            }
        } catch (error) {
            alert('Erro ao enviar a solicitação: ' + error.message);
        }
    };
})();
