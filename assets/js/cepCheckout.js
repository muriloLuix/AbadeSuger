document.getElementById('cep').addEventListener('input', function (e) {
    let cep = e.target.value.replace(/\D/g, '');
    if (cep.length > 5) {
        cep = cep.slice(0, 5) + '-' + cep.slice(5, 8);
    }
    e.target.value = cep;

    // Consulta a API de CEP quando o CEP está completo
    if (cep.length === 9) {
        fetch(`https://viacep.com.br/ws/${cep.replace('-', '')}/json/`)
            .then(response => response.json())
            .then(data => {
                if (!data.erro) {
                    document.getElementById('rua').value = data.logradouro || '';
                    document.getElementById('bairro').value = data.bairro || '';
                    document.getElementById('estado').value = data.uf || '';
                } else {
                    alert('CEP não encontrado.');
                }
            })
            .catch(() => {
                alert('Erro ao consultar o CEP.');
            });
    }
});
