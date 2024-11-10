export function mascaraTelefone(input) {
    let value = input.value.replace(/\D/g, '');
    value = value.replace(/^(\d{2})(\d)/, '($1) $2');
    value = value.replace(/(\d)(\d{4})$/, '$1-$2');
    input.value = value;
}

export function mascaraCEP(input) {
    let value = input.value.replace(/\D/g, ''); 
    value = value.replace(/^(\d{5})(\d{1,3})$/, '$1-$2');
    input.value = value;
}

export function mascaraData(input) {
    let value = input.value.replace(/\D/g, ''); 
    value = value.replace(/(\d{2})(\d)/, '$1/$2'); 
    value = value.replace(/(\d{2})(\d)/, '$1/$2'); 
    input.value = value;
}

export function mascaraCPF(input) {
    let value = input.value.replace(/\D/g, ''); // Remove tudo que não é número
    if (value.length <= 11) {
        value = value.replace(/(\d{3})(\d)/, "$1.$2");
        value = value.replace(/(\d{3})(\d)/, "$1.$2");
        value = value.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
    }
    input.value = value;
}