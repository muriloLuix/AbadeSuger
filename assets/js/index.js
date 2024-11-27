import { mascaraTelefone } from './replace.js';
import { mascaraCEP } from './replace.js';
import { mascaraData } from './replace.js';
import { mascaraCPF } from './replace.js';

document.getElementById("cli_cpf").addEventListener("input", function () {
    mascaraCPF(this);
});
document.getElementById("cli_dtnasc").addEventListener("input", function () {
    mascaraData(this);
});

document.getElementById("cli_cep").addEventListener("input", function () {
    mascaraCEP(this);
});

document.getElementById("cli_telefone").addEventListener("input", function () {
    mascaraTelefone(this);
});