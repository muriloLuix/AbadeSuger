document.getElementById('aplicarCupom').addEventListener('click', function () {
    var cupom = document.getElementById('cupom').value;
    var compra_id = 123;  // Exemplo de ID da compra, deve ser obtido dinamicamente no frontend

    if (cupom.trim() === "") {
        mostrarModal("Por favor, insira um código de cupom.");
        return;
    }

    // Verificar se o cupom já foi aplicado anteriormente (no localStorage)
    var cupomAplicado = localStorage.getItem('cupomAplicado');
    
    if (cupomAplicado) {
        // Se o cupom já foi aplicado, mostrar mensagem e impedir aplicação
        mostrarModal("Este cupom já foi aplicado nesta compra.");
        return;
    }

    // Enviar o cupom via AJAX
    fetch('../php/validar_cupom.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ cupom: cupom, compra_id: compra_id })
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'erro') {
                // Exibir modal de erro
                mostrarModal("Código de cupom incorreto, expirado ou já utilizado nesta compra.");
            } else {
                // Aplicar desconto no valor
                let desconto = data.desconto;
                let valorOriginal = parseFloat(document.querySelector('.subTotalPrice').textContent.replace('R$ ', '').replace('.', '').replace(',', '.'));
                let novoValor = valorOriginal - (valorOriginal * (desconto / 100));

                // Atualizar os valores na página
                document.querySelector('.subTotalPrice').textContent = 'R$ ' + novoValor.toFixed(2).replace('.', ',');
                document.querySelector('.priceProductFinal').textContent = 'R$ ' + novoValor.toFixed(2).replace('.', ',');
                document.querySelector('.priceAvista').textContent = 'R$ ' + novoValor.toFixed(2).replace('.', ',');

                // Exibir o modal de sucesso
                mostrarModalSucesso("Cupom aplicado com sucesso!");

                // Armazenar no localStorage para impedir reutilização do cupom
                localStorage.setItem('cupomAplicado', cupom);
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            mostrarModal("Houve um erro ao aplicar o cupom.");
        });
});

// Função para exibir o modal com a mensagem personalizada
function mostrarModal(mensagem) {
    document.querySelector('#modalErro .modal-content p').textContent = mensagem;
    document.getElementById('modalErro').style.display = 'block';
}

// Função para exibir o modal de sucesso
function mostrarModalSucesso(mensagem) {
    document.querySelector('#modalSucesso .modal-content p').textContent = mensagem;
    document.getElementById('modalSucesso').style.display = 'block';
}

// Função para fechar qualquer modal
function closeModal() {
    document.getElementById('modalErro').style.display = 'none';
    document.getElementById('modalSucesso').style.display = 'none';
}
