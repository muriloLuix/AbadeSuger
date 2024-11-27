(() => {
    const modalExcluirCategoria = document.getElementById('modalExcluirCategoria');
    const closeExcluirCategoria = document.getElementById('closeExcluirCategoria');
    const cancelExcluirCategoria = document.getElementById('cancelExcluirCategoria');
    const formExcluirCategoria = document.getElementById('formExcluirCategoria');

    // Abrir o modal de exclusão ao clicar no botão "Excluir"
    document.addEventListener('click', (event) => {
        if (event.target.classList.contains('btn-excluir-categoria')) {
            const catId = event.target.getAttribute('data-id');

            // Define o ID da categoria no input oculto
            document.getElementById('delete_cat_id').value = catId;

            // Abre o modal
            modalExcluirCategoria.style.display = 'block';
        }
    });

    // Fechar o modal ao clicar no botão "X"
    closeExcluirCategoria.onclick = () => {
        modalExcluirCategoria.style.display = 'none';
    };

    // Cancelar exclusão ao clicar no botão "Cancelar"
    cancelExcluirCategoria.onclick = () => {
        modalExcluirCategoria.style.display = 'none';
    };

    // Submeter o formulário de exclusão via AJAX
    formExcluirCategoria.onsubmit = async (event) => {
        event.preventDefault();

        const formData = new FormData(formExcluirCategoria);

        try {
            const response = await fetch('../php/excluir_categoria.php', {
                method: 'POST',
                body: formData,
            });

            const result = await response.text();

            if (result.trim() === 'success') {
                alert('Categoria excluída com sucesso!');

                // Remove a linha correspondente da tabela
                const catId = formData.get('cat_id');
                const row = document.querySelector(`tr[data-id="${catId}"]`);
                if (row) {
                    row.remove();
                } else {
                    console.error(`Linha da categoria com ID ${catId} não encontrada.`);
                }


                // Fecha o modal
                modalExcluirCategoria.style.display = 'none';
            } else {
                alert('Erro ao excluir a categoria: ' + result);
            }
        } catch (error) {
            alert('Erro ao enviar a solicitação: ' + error.message);
        }
    };
})();
