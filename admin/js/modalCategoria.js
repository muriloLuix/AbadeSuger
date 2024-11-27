document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('modalCategoria');
    const closeModal = document.querySelector('.closeModalCategoria');
    const formEditarCategoria = document.getElementById('formEditarCategoria');

    // Abrir modal ao clicar no botão de editar
    document.querySelectorAll('.btn-editar-categoria').forEach(button => {
        button.addEventListener('click', function () {
            const catId = this.getAttribute('data-id');
            document.getElementById('cat_id').value = catId;

            const catNome = this.getAttribute('data-nome'); // Pega o nome da categoria

            // Define os valores no formulário
            document.getElementById('cat_id').value = catId;
            document.getElementById('edit_cat_nome').value = catNome;

            // Abre o modal
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
    formEditarCategoria.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch(this.action, {
            method: 'POST',
            body: formData
        })
            .then(response => response.text())
            .then(result => {
                if (result.trim() === 'success') {
                    alert('Categoria editada com sucesso!');
                    window.location.reload(); // Recarregar a página para mostrar as mudanças
                } else {
                    alert('Erro ao editar a categoria.');
                }
            })
            .catch(error => {
                console.error('Erro na requisição:', error);
                alert('Erro ao processar a requisição.');
            });
    });
});

document.querySelector('.formCategoria').addEventListener('submit', function (e) {
    e.preventDefault(); // Impede o envio do formulário padrão

    // Cria o objeto FormData para enviar os dados
    var formData = new FormData(this);

    // Faz a requisição AJAX
    var xhr = new XMLHttpRequest();
    xhr.open('POST', this.action, true);

    xhr.onload = function () {
        if (xhr.status === 200) {
            // Verifica se a resposta do servidor foi bem-sucedida
            if (xhr.responseText.trim() === "success") {
                // Exibe o alerta de sucesso
                alert("Categoria cadastrada com sucesso!");

                // Adiciona a nova categoria na tabela
                var novaCategoriaNome = document.getElementById('cat_nome').value;

                // Cria uma nova linha na tabela
                var tabelaCategorias = document.getElementById('tabelaCategorias').getElementsByTagName('tbody')[0];
                var novaLinha = tabelaCategorias.insertRow();
                var celulaNome = novaLinha.insertCell(0);
                var celulaAcoes = novaLinha.insertCell(1);

                // Preenche as células com os dados da nova categoria
                celulaNome.textContent = novaCategoriaNome;
                celulaAcoes.innerHTML = "<button class='btn-editar-categoria' data-nome='" + novaCategoriaNome + "'>Editar</button>";

                // Limpa o campo de entrada do formulário
                document.getElementById('cat_nome').value = '';
            } else {
                alert('Erro ao cadastrar a categoria.');
            }
        } else {
            alert('Erro na requisição AJAX.');
        }
    };

    xhr.send(formData);
});

