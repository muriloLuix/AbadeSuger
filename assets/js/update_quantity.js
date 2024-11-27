document.querySelectorAll('.quantityButton').forEach(button => {
    button.addEventListener('click', function () {
        const isIncrement = this.textContent === '+'; // Verifica se é botão "+"
        const quantityValue = this.parentNode.querySelector('.quantityValue'); // Elemento que exibe a quantidade
        const priceElement = this.closest('.productCard').querySelector('.priceProduct .priceValue'); // Preço do item
        const subtotalElement = document.querySelector('.subTotalPrice'); // Subtotal geral
        const carrinhoId = this.closest('.productCard').querySelector('.closeButton').getAttribute('data-carrinho-id');

        let currentQuantity = parseInt(quantityValue.textContent) || 1; // Quantidade atual
        const price = parseFloat(priceElement.textContent.replace('R$', '').replace(',', '.')) || 0; // Preço do item

        // Atualiza a quantidade no frontend
        if (isIncrement) {
            currentQuantity++;
        } else if (currentQuantity > 1) {
            currentQuantity--;
        }

        // Atualiza o valor exibido na quantidade
        quantityValue.textContent = currentQuantity;

        // Recalcula o subtotal no frontend
        let subtotal = 0;
        document.querySelectorAll('.productCard').forEach(card => {
            const itemPrice = parseFloat(card.querySelector('.priceProduct .priceValue').textContent.replace('R$', '').replace(',', '.')) || 0;
            const itemQuantity = parseInt(card.querySelector('.quantityValue').textContent) || 1;
            subtotal += itemPrice * itemQuantity;
        });

        // Atualiza o subtotal exibido
        subtotalElement.textContent = `R$ ${subtotal.toFixed(2).replace('.', ',')}`;

        // Enviar atualização para o servidor
        fetch('../php/update_quantity.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                carrinho_id: carrinhoId,
                quantidade: currentQuantity
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    console.log('Quantidade e subtotal atualizados com sucesso no servidor');
                    if (data.subtotal) {
                        subtotalElement.textContent = `R$ ${parseFloat(data.subtotal).toFixed(2).replace('.', ',')}`;
                    }
                } else {
                    console.error('Erro ao atualizar quantidade no servidor:', data.message);
                }
            })

            .catch(error => console.error('Erro na requisição:', error));
    });
});
