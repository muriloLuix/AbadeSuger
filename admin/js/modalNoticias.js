(() => {
    const modalNoticias = document.getElementById('modalNoticias');
    const btnAbrirModalNoticias = document.getElementById('btnAbrirModalNoticias');
    const spanCloseNoticias = document.querySelector('#modalNoticias .close-button');
    const formNoticias = document.getElementById('formNoticias');
    const tabelaNoticias = document.querySelector('#tabelaNoticias tbody');

    // Abre o modal ao clicar no botão
    btnAbrirModalNoticias.onclick = function () {
        modalNoticias.style.display = 'block';
    };

    // Fecha o modal ao clicar no botão "X"
    spanCloseNoticias.onclick = function () {
        modalNoticias.style.display = 'none';
    };

    // Fecha o modal ao clicar fora do conteúdo
    window.onclick = function (event) {
        if (event.target == modalNoticias) {
            modalNoticias.style.display = 'none';
        }
    };

    // Envia o formulário via Ajax
    formNoticias.onsubmit = async function (event) {
        event.preventDefault();

        const formData = new FormData(formNoticias);

        try {
            const response = await fetch('../php/cadastrar_noticia.php', {
                method: 'POST',
                body: formData,
            });

            const result = await response.text();

            if (result.trim() === 'success') {
                alert('Notícia cadastrada com sucesso!');

                // Atualiza a tabela de notícias
                const notTitulo = formData.get('not_titulo');
                const notResumo = formData.get('not_resumo');
                const notResp = formData.get('not_resp');
                const notDtCriacao = formData.get('not_dtcriacao');

                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td>${notTitulo}</td>
                    <td>${notResumo}</td>
                    <td>${notResp}</td>
                    <td>${notDtCriacao}</td>
                    <td>
                        <button class="btn-editar-noticia">Editar</button>
                        <button class="btn-excluir-noticia">Excluir</button>
                    </td>
                `;
                tabelaNoticias.appendChild(newRow);

                formNoticias.reset();
                modalNoticias.style.display = 'none';
            } else {
                alert('Erro ao cadastrar notícia: ' + result);
            }
        } catch (error) {
            alert('Erro ao enviar a solicitação: ' + error.message);
        }
    };
})();
