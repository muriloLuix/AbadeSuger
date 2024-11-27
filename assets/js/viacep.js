document.getElementById('cep').addEventListener('blur', function () {
    const cep = this.value.replace(/\D/g, ''); // Remove caracteres não numéricos

    if (cep.length !== 8) {
        alert('Por favor, insira um CEP válido.');
        return;
    }

    // Consulta a API da ViaCEP
    fetch(`https://viacep.com.br/ws/${cep}/json/`)
        .then(response => response.json())
        .then(data => {
            if (data.erro) {
                alert('CEP não encontrado.');
            } else {
                // Exemplo de uso dos dados retornados
                console.log('Dados do CEP:', data);

                // Calcular frete baseado no estado, cidade ou outro critério
                const valorFrete = calcularFrete(data);
                document.getElementById('frete').textContent = `R$ ${valorFrete.toFixed(2).replace('.', ',')}`;
            }
        })
        .catch(error => console.error('Erro ao consultar o CEP:', error));
});

// Função para calcular o frete com base nos dados do CEP
function calcularFrete(data) {
    // Exemplo simples: calcular frete com base no estado
    const estado = data.uf;

    switch (estado) {
        case 'SP':
            return 10.00; // Frete para São Paulo
        case 'RJ':
            return 15.00; // Frete para Rio de Janeiro
        default:
            return 20.00; // Frete para outros estados
    }
}

document.querySelector('.inputFrete button').addEventListener('click', function (event) {
    event.preventDefault(); // Evita o envio do formulário, se for o caso

    const cepInput = document.getElementById('cep');
    const freteWrapper = document.querySelector('.freteWrapper');

    // Verifica se o CEP está preenchido
    if (!cepInput.value.trim()) {
        alert('Por favor, insira um CEP válido.');
        return;
    }

    // Exibe o frete
    freteWrapper.style.display = 'block';
});
