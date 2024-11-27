(() => {
    const modalEditarNoticias = document.getElementById('modalEditarNoticias');
    const closeEditarNoticias = document.getElementById('closeEditarNoticias');
    const formEditarNoticias = document.getElementById('formEditarNoticias');

    // Abre o modal com os dados da notícia
    document.addEventListener('click', async (event) => {
        if (event.target.classList.contains('btn-editar-noticia')) {
            const noticiaId = event.target.getAttribute('data-id');

            const response = await fetch(`../php/get_noticia.php?id=${noticiaId}`);
            const noticia = await response.json();

            document.getElementById('edit_not_id').value = noticia.not_id;
            document.getElementById('edit_not_titulo').value = noticia.not_titulo;
            document.getElementById('edit_not_resumo').value = noticia.not_resumo;
            document.getElementById('edit_not_desc').value = noticia.not_desc;
            document.getElementById('edit_not_resp').value = noticia.not_resp;
            document.getElementById('edit_not_prioridade').checked = noticia.not_prioridade;

            modalEditarNoticias.style.display = 'block';
        }
    });

    // Fecha o modal ao clicar no botão "X"
    closeEditarNoticias.onclick = () => {
        modalEditarNoticias.style.display = 'none';
    };

    // Submeter o formulário de edição via Ajax
    formEditarNoticias.onsubmit = async (event) => {
        event.preventDefault();

        const formData = new FormData(formEditarNoticias);

        try {
            const response = await fetch('../php/editar_noticia.php', {
                method: 'POST',
                body: formData,
            });

            const result = await response.text();

            if (result.trim() === 'success') {
                alert('Notícia editada com sucesso!');

                const noticiaId = formData.get('not_id');
                const row = document.querySelector(`tr[data-id="${noticiaId}"]`);
                row.querySelector('td:nth-child(1)').textContent = formData.get('not_titulo');
                row.querySelector('td:nth-child(2)').textContent = formData.get('not_resumo');
                row.querySelector('td:nth-child(3)').textContent = formData.get('not_resp');
                row.querySelector('td:nth-child(5)').textContent = formData.has('not_prioridade') ? 'Sim' : 'Não';

                modalEditarNoticias.style.display = 'none';
            } else {
                alert('Erro ao editar a notícia: ' + result);
            }
        } catch (error) {
            alert('Erro ao enviar a solicitação: ' + error.message);
        }
    };
})();
