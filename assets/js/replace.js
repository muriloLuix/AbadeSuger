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