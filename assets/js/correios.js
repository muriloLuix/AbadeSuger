// Função para formatar o CEP enquanto o usuário digita
function formatarCep(input) {
    let valor = input.value.replace(/\D/g, ''); // Remove qualquer caractere não numérico
    if (valor.length > 5) {
        valor = valor.substring(0, 5) + '-' + valor.substring(5, 8);
    }
    input.value = valor;
}

document.getElementById('calcularFreteBtn').addEventListener('click', function () {
    var cep = document.getElementById('cep').value.replace(/\D/g, ''); // Remove o traço para a API
    if (cep.length === 8) { // Verifica se o CEP tem 8 dígitos
        calcularFrete(cep);
    } else {
        alert('Por favor, insira um CEP válido.');
    }
});
function calcularFrete(cep) {
    var url = `http://localhost:3000/calcular-frete/${cep}`;  // Requisição para o backend

    fetch(url)
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if (data && data.logradouro) {
                var valorFrete = 20; // Substitua com o valor real do frete
                document.getElementById('freteResultado').innerHTML = `Frete estimado: R$ ${valorFrete.toFixed(2)}`;
            } else {
                document.getElementById('freteResultado').innerHTML = 'CEP não encontrado. Verifique o número e tente novamente.';
            }
        })
        .catch(error => {
            console.error('Erro ao consultar o CEP:', error);
            document.getElementById('freteResultado').innerHTML = 'Erro ao calcular o frete. Tente novamente mais tarde.';
        });
}
