(() => {
    const modalExcluirCupom = document.getElementById('modalExcluirCupom');
    const closeExcluirCupom = document.getElementById('closeExcluirCupom');
    const cancelExcluirCupom = document.getElementById('cancelExcluirCupom');
    const formExcluirCupom = document.getElementById('formExcluirCupom');

    // Abrir o modal de exclusão ao clicar no botão "Excluir"
    document.addEventListener('click', (event) => {
        if (event.target.classList.contains('btn-excluir-cupom')) {
            const cupId = event.target.getAttribute('data-id');

            // Define o ID do cupom no input oculto
            document.getElementById('delete_cup_id').value = cupId;

            // Abre o modal
            modalExcluirCupom.style.display = 'block';
        }
    });

    // Fechar o modal ao clicar no botão "X"
    closeExcluirCupom.onclick = () => {
        modalExcluirCupom.style.display = 'none';
    };

    // Cancelar exclusão ao clicar no botão "Cancelar"
    cancelExcluirCupom.onclick = () => {
        modalExcluirCupom.style.display = 'none';
    };

    // Submeter o formulário de exclusão via AJAX
    formExcluirCupom.onsubmit = async (event) => {
        event.preventDefault();

        const formData = new FormData(formExcluirCupom);

        try {
            const response = await fetch('../php/excluir_cupom.php', {
                method: 'POST',
                body: formData,
            });

            const result = await response.text();

            if (result.trim() === 'success') {
                alert('Cupom excluído com sucesso!');

                // Remove a linha correspondente da tabela
                const cupId = formData.get('cup_id');
                const row = document.querySelector(`tr[data-id="${cupId}"]`);
                row.remove();

                // Fecha o modal
                modalExcluirCupom.style.display = 'none';
            } else {
                alert('Erro ao excluir o cupom: ' + result);
            }
        } catch (error) {
            alert('Erro ao enviar a solicitação: ' + error.message);
        }
    };
})();
