// Abrir o modal de edição quando clicar no botão "Editar"
document.querySelectorAll('.btn-editar-cupom').forEach(button => {
    button.addEventListener('click', function() {
        // Recupera os dados do cupom
        const cupId = this.getAttribute('data-id');
        const cupCodigo = this.getAttribute('data-codigo');
        const cupDesconto = this.getAttribute('data-desconto');
        const cupValidade = this.getAttribute('data-validade');

        // Preenche os campos do formulário com os dados
        document.getElementById('edit_cup_id').value = cupId;
        document.getElementById('edit_cup_codigo').value = cupCodigo;
        document.getElementById('edit_cup_desconto').value = cupDesconto;
        document.getElementById('edit_cup_dtvalidade').value = cupValidade;

        // Mostra o modal
        document.getElementById('modalEditarCupom').style.display = 'block';
    });
});

// Fechar o modal quando clicar no "X"
document.querySelector('.closeEditarCupom').addEventListener('click', function() {
    document.getElementById('modalEditarCupom').style.display = 'none';
});

// Fechar o modal se clicar fora da caixa do modal
window.addEventListener('click', function(event) {
    if (event.target == document.getElementById('modalEditarCupom')) {
        document.getElementById('modalEditarCupom').style.display = 'none';
    }
});

// Processar o envio do formulário via AJAX
document.getElementById('formEditarCupom').addEventListener('submit', function(e) {
    e.preventDefault(); // Impede o envio padrão do formulário

    var formData = new FormData(this);

    // Envia a requisição AJAX
    var xhr = new XMLHttpRequest();
    xhr.open('POST', this.action, true);

    xhr.onload = function() {
        if (xhr.status === 200) {
            // Exibe a mensagem de sucesso
            alert('Cupom atualizado com sucesso!');
            // Atualiza a lista de cupons sem redirecionar
            document.getElementById('tabelaCupons').innerHTML = xhr.responseText;
            // Fecha o modal
            document.getElementById('modalEditarCupom').style.display = 'none';
        } else {
            alert('Erro ao atualizar o cupom.');
        }
    };

    xhr.send(formData);
});
