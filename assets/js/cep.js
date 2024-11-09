function buscarEndereco() {
    const cep = document.getElementById('cli_cep').value.replace(/\D/g, '');

    if (cep.length === 8) { // Confirma que o CEP tem 8 dígitos
        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(response => response.json())
            .then(data => {
                if (!data.erro) {
                    document.getElementById('cli_rua').value = data.logradouro || '';
                    document.getElementById('cli_bairro').value = data.bairro || '';
                    document.getElementById('cli_cidade').value = data.localidade || '';
                    document.getElementById('cli_estado').value = data.uf || '';
                } else {
                    alert('CEP não encontrado!');
                }
            })
            .catch(() => alert('Erro ao buscar CEP.'));
    } else {
        alert('Por favor, informe um CEP válido.');
    }
}