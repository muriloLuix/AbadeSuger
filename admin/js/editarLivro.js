// Função para abrir o modal de edição
function abrirModalEditarLivro(liv_id) {
    // Abrir o modal
    document.getElementById('editarLivroModal').style.display = 'block';

    // Fazer a requisição para pegar os dados do livro
    fetch(`../php/get_livro.php?id=${liv_id}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert("Erro: " + data.error);
            } else {
                // Preencher os campos do livro
                document.getElementById('edit_liv_id').value = data.livro.liv_id;
                document.getElementById('edit_titulo').value = data.livro.liv_titulo;
                document.getElementById('edit_preco').value = data.livro.liv_preco;
                document.getElementById('edit_estoque').value = data.livro.liv_estoque;
                document.getElementById('edit_desc').value = data.livro.liv_desc;
                document.getElementById('edit_adc').value = data.livro.liv_adicional;
                document.getElementById('edit_pag').value = data.livro.liv_pag;

                // Preencher categorias no select
                const categoriaSelect = document.getElementById('edit_cat_id');
                categoriaSelect.innerHTML = ""; // Limpa as opções existentes
                data.categorias.forEach(categoria => {
                    const option = document.createElement('option');
                    option.value = categoria.cat_id;
                    option.textContent = categoria.cat_nome;
                    if (categoria.cat_id == data.livro.cat_id) {
                        option.selected = true; // Marca como selecionada
                    }
                    categoriaSelect.appendChild(option);
                });

                // Preencher atividades no select
                const atividadeSelect = document.getElementById('edit_atv_id');
                atividadeSelect.innerHTML = ""; // Limpa as opções existentes
                data.atividades.forEach(atividade => {
                    const option = document.createElement('option');
                    option.value = atividade.atv_id;
                    option.textContent = atividade.atv_desc;
                    if (atividade.atv_id == data.livro.atv_id) {
                        option.selected = true; // Marca como selecionada
                    }
                    atividadeSelect.appendChild(option);
                });
            }
        })
        .catch(error => {
            console.error('Erro na requisição:', error);
            alert("Erro ao carregar os dados do livro.");
        });
}

// Função para fechar o modal de edição
function fecharModal() {
    document.getElementById('editarLivroModal').style.display = 'none';
}

// Enviar o formulário de edição via AJAX
document.getElementById('formEditarLivro').addEventListener('submit', function (e) {
    e.preventDefault(); // Impede o envio tradicional do formulário

    const formData = new FormData(this); // Captura os dados do formulário

    // Enviar os dados via AJAX
    fetch('../php/editar_livro.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.text())
        .then(data => {
            if (data.trim() === 'Livro atualizado com sucesso!') {
                // Exibir alerta de sucesso
                alert(data);

                // Fechar o modal
                fecharModal();

                // Atualizar a tabela ou os dados na página sem recarregar
                atualizarListaLivros();
            } else {
                // Exibir mensagem de erro caso ocorra
                alert(data);
            }
        })
        .catch(error => {
            console.error('Erro ao salvar o livro:', error);
            alert('Erro ao salvar o livro. Tente novamente.');
        });
});

// Adicionar evento de clique aos botões de editar
document.querySelectorAll('.btn-editar-livro').forEach(button => {
    button.addEventListener('click', function () {
        const livroId = this.getAttribute('data-id');
        if (livroId) {
            abrirModalEditarLivro(livroId);
        } else {
            console.error('ID do livro não encontrado');
        }
    });
});

// Função para atualizar a lista de livros (opcional)
function atualizarListaLivros() {
    // Você pode implementar esta função para buscar a lista atualizada de livros
    // sem recarregar a página. Por enquanto, apenas simula uma atualização.
    console.log("Lista de livros atualizada.");
}
