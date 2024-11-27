document.querySelectorAll('.quantityButton').forEach(button => {
    button.addEventListener('click', function () {
        const isIncrement = this.textContent === '+'; // Verifica se é incremento
        const carrinhoId = this.getAttribute('data-carrinho-id'); // Busca o ID do carrinho
        const quantitySpan = this.closest('.quantityControl').querySelector('.quantityValue'); // Seleciona a quantidade atual

        // Verifica e ajusta a quantidade
        let currentQuantity = parseInt(quantitySpan.textContent.trim(), 10); // Valor atual
        if (isNaN(currentQuantity)) return; // Se inválido, não faz nada

        const newQuantity = isIncrement ? currentQuantity + 1 : currentQuantity - 1;
        if (newQuantity < 1) return; // Evita quantidades menores que 1

        // Atualiza a quantidade no servidor
        fetch('../php/update_quantity.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ carrinhoId: carrinhoId, quantidade: newQuantity })
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Recarrega a página para refletir as alterações
                    window.location.reload();
                } else {
                    console.error('Erro ao atualizar a quantidade:', data.message);
                }
            })
            .catch(error => console.error('Erro ao comunicar com o servidor:', error));
    });
});
