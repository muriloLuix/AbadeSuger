document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('modalEditora');
    const closeModal = document.querySelector('.closeModalEditora');
    const formEditarEditora = document.getElementById('formEditarEditora');

    // Abrir modal ao clicar no botão de editar
    document.querySelectorAll('.btn-editar-editora').forEach(button => {
        button.addEventListener('click', function () {
            const ediId = this.getAttribute('data-id');
            const ediNome = this.getAttribute('data-nome');

            document.getElementById('edit_edi_id').value = ediId;
            document.getElementById('edit_edi_nome').value = ediNome;

            modal.style.display = 'block';
        });
    });

    // Fechar modal ao clicar no botão de fechar
    closeModal.addEventListener('click', function () {
        modal.style.display = 'none';
    });

    // Fechar modal ao clicar fora do conteúdo do modal
    window.addEventListener('click', function (e) {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });

    // Enviar formulário via AJAX
    formEditarEditora.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch(this.action, {
            method: 'POST',
            body: formData
        })
            .then(response => response.text())
            .then(result => {
                if (result.trim() === 'success') {
                    alert('Editora editada com sucesso!');

                    // Atualizar o nome da editora na tabela sem recarregar a página
                    const ediId = document.getElementById('edit_edi_id').value;
                    const ediNome = document.getElementById('edit_edi_nome').value;

                    // Encontrar a linha da editora na tabela
                    const linhaEditora = document.querySelector(`tr[data-id='${ediId}']`);
                    if (linhaEditora) {
                        const celulaNome = linhaEditora.querySelector('td');
                        celulaNome.textContent = ediNome;
                    }

                    // Fechar o modal após a edição
                    modal.style.display = 'none';
                } else {
                    alert('Erro ao editar a editora.');
                }
            })
            .catch(error => {
                console.error('Erro na requisição:', error);
                alert('Erro ao processar a requisição.');
            });
    });
});
