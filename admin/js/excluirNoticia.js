(() => {
    const modalExcluirNoticias = document.getElementById('modalExcluirNoticias');
    const closeExcluirNoticias = document.getElementById('closeExcluirNoticias');
    const cancelExcluirNoticias = document.getElementById('cancelExcluirNoticias');
    const formExcluirNoticias = document.getElementById('formExcluirNoticias');

    // Abrir o modal de exclusão
    document.addEventListener('click', (event) => {
        if (event.target.classList.contains('btn-excluir-noticia')) {
            const noticiaId = event.target.getAttribute('data-id');

            // Define o ID da notícia no input oculto
            document.getElementById('delete_not_id').value = noticiaId;

            // Abre o modal
            modalExcluirNoticias.style.display = 'block';
        }
    });

    // Fechar o modal ao clicar no botão "X"
    closeExcluirNoticias.onclick = () => {
        modalExcluirNoticias.style.display = 'none';
    };

    // Cancelar exclusão ao clicar no botão de cancelar
    cancelExcluirNoticias.onclick = () => {
        modalExcluirNoticias.style.display = 'none';
    };

    // Submeter o formulário de exclusão via Ajax
    formExcluirNoticias.onsubmit = async (event) => {
        event.preventDefault();

        const formData = new FormData(formExcluirNoticias);

        try {
            const response = await fetch('../php/excluir_noticia.php', {
                method: 'POST',
                body: formData,
            });

            const result = await response.text();

            if (result.trim() === 'success') {
                alert('Notícia excluída com sucesso!');

                // Remove a linha correspondente da tabela
                const noticiaId = formData.get('not_id');
                const row = document.querySelector(`tr[data-id="${noticiaId}"]`);
                row.remove();

                // Fecha o modal
                modalExcluirNoticias.style.display = 'none';
            } else {
                alert('Erro ao excluir notícia: ' + result);
            }
        } catch (error) {
            alert('Erro ao enviar a solicitação: ' + error.message);
        }
    };
})();
