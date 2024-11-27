document.querySelectorAll('.closeButton').forEach(button => {
    button.addEventListener('click', function () {
        const livId = this.getAttribute('data-liv-id'); // ID do livro no carrinho
        const productCard = this.closest('.productCard'); // Seleciona o card do produto

        console.log('Tentando remover item com livId:', livId); // Log de depuração

        fetch('../php/remover_carrinho.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ liv_id: livId }) // Enviando apenas liv_id
        })
            .then(response => response.json())
            .then(data => {
                console.log('Resposta do servidor:', data); // Log da resposta
                if (data.status === 'sucesso') {
                    console.log('Produto removido com sucesso.');

                    // Atualiza a página automaticamente após a exclusão
                    window.location.reload();
                } else {
                    console.error('Erro ao remover o produto:', data.message);
                }
            })
            .catch(error => console.error('Erro ao comunicar com o servidor:', error));
    });
});
