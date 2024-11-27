document.querySelectorAll('.buy-button').forEach(button => {
    button.addEventListener('click', function(event) {
        event.preventDefault(); // Impede o comportamento padrão

        const livroId = this.getAttribute('data-livro-id');
        const clienteId = this.getAttribute('data-cli-id');
        const livroPreco = this.getAttribute('data-liv-preco');

        console.log('Clique detectado! Dados enviados:', { livroId, clienteId, livroPreco });

        // Enviar via AJAX
        fetch('../php/adicionar_carrinho.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                liv_id: livroId,
                cli_id: clienteId,
                liv_preco: livroPreco
            })
        })
        .then(response => response.json())
        .then(data => {
            console.log('Resposta do servidor:', data);

            if (data.status === 'sucesso') {
                // Selecionar o badge do carrinho
                const badge = document.getElementById('bag-badge');
                if (badge) {
                    console.log('Elemento bag-badge encontrado. Atualizando...');
                    console.log('Valor atual do badge:', badge.textContent);

                    let currentCount = parseInt(badge.textContent) || 0;
                    badge.textContent = currentCount + 1; // Incrementa o contador
                    console.log('Novo valor do badge:', badge.textContent);

                    // Força a renderização do DOM
                    badge.style.display = 'none';
                    setTimeout(() => {
                        badge.style.display = 'inline'; // Garante que o navegador re-renderize
                    }, 50);
                } else {
                    console.error('Elemento bag-badge não encontrado no DOM.');
                }
            } else {
                console.error('Erro no retorno do servidor:', data.message);
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Erro na requisição AJAX:', error);
            alert('Houve um erro ao tentar adicionar ao carrinho.');
        });
    });
});
