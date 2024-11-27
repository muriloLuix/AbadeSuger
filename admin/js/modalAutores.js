(() => {
    const modalExcluirAutor = document.getElementById('modalExcluirAutor');
    const closeExcluirAutor = document.getElementById('closeExcluirAutor');
    const cancelExcluirAutor = document.getElementById('cancelExcluirAutor');
    const formExcluirAutor = document.getElementById('formExcluirAutor');

    // Abrir o modal de exclusão ao clicar no botão "Excluir"
    document.addEventListener('click', (event) => {
        if (event.target.classList.contains('btn-excluir-autor')) {
            const autId = event.target.getAttribute('data-id');

            // Define o ID do autor no input oculto
            document.getElementById('delete_aut_id').value = autId;

            // Abre o modal
            modalExcluirAutor.style.display = 'block';
        }
    });

    // Fechar o modal ao clicar no botão "X"
    closeExcluirAutor.onclick = () => {
        modalExcluirAutor.style.display = 'none';
    };

    // Cancelar exclusão ao clicar no botão "Cancelar"
    cancelExcluirAutor.onclick = () => {
        modalExcluirAutor.style.display = 'none';
    };

    // Submeter o formulário de exclusão via AJAX
    formExcluirAutor.onsubmit = async (event) => {
        event.preventDefault();

        const formData = new FormData(formExcluirAutor);

        try {
            const response = await fetch('../php/excluir_autor.php', {
                method: 'POST',
                body: formData,
            });

            const result = await response.json();

            if (result.success) {
                alert('Autor excluído com sucesso!');

                // Remove a linha correspondente da tabela
                const autId = formData.get('aut_id');
                const row = document.querySelector(`#autor_${autId}`);
                if (row) row.remove();

                // Fecha o modal
                modalExcluirAutor.style.display = 'none';
            } else {
                alert('Erro ao excluir o autor: ' + result.message);
            }
        } catch (error) {
            alert('Erro ao enviar a solicitação: ' + error.message);
        }
    };
})();


(() => {
    const modalEditarAutor = document.getElementById('modalAutor');
    const closeEditarAutor = document.querySelector('.closeModalAutor');
    const formEditarAutor = document.getElementById('formEditarAutor');
    const inputAutId = document.getElementById('edit_aut_id');
    const inputAutNome = document.getElementById('edit_aut_nome');

    // Abrir o modal de edição ao clicar no botão "Editar"
    document.addEventListener('click', (event) => {
        if (event.target.classList.contains('btn-editar-autor')) {
            const autId = event.target.getAttribute('data-id');
            const row = document.querySelector(`#autor_${autId}`);
            const autNome = row.querySelector('td:first-child').textContent.trim();

            // Preenche os campos do modal com os dados do autor
            inputAutId.value = autId;
            inputAutNome.value = autNome;

            // Exibe o modal
            modalEditarAutor.style.display = 'block';
        }
    });

    // Fechar o modal ao clicar no botão "X"
    closeEditarAutor.onclick = () => {
        modalEditarAutor.style.display = 'none';
    };

    // Fechar o modal ao clicar fora dele
    window.onclick = (event) => {
        if (event.target === modalEditarAutor) {
            modalEditarAutor.style.display = 'none';
        }
    };

    // Submeter o formulário de edição via AJAX
    formEditarAutor.onsubmit = async (event) => {
        event.preventDefault();

        const formData = new FormData(formEditarAutor);

        try {
            const response = await fetch('../php/editar_autor.php', {
                method: 'POST',
                body: formData,
            });

            const result = await response.json();

            if (result.success) {
                alert('Autor atualizado com sucesso!');

                // Atualiza o nome do autor na tabela
                const autId = formData.get('aut_id');
                const row = document.querySelector(`#autor_${autId}`);
                if (row) {
                    row.querySelector('td:first-child').textContent = formData.get('aut_nome');
                }

                // Fecha o modal
                modalEditarAutor.style.display = 'none';
            } else {
                alert('Erro ao atualizar o autor: ' + result.message);
            }
        } catch (error) {
            alert('Erro ao enviar a solicitação: ' + error.message);
        }
    };
})();
