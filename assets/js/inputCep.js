const cepInput = document.getElementById('cep');

cepInput.addEventListener('input', () => {
    let cep = cepInput.value.replace(/\D/g, ''); // Remove caracteres não numéricos
    if (cep.length > 5) {
        cep = cep.slice(0, 5) + '-' + cep.slice(5);
    }
    cepInput.value = cep;
});