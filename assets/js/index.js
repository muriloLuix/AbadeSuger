import { mascaraTelefone } from './replace.js';
import { mascaraCEP } from './replace.js';
import { mascaraData } from './replace.js';

document.getElementById("cli_dtnasc").addEventListener("input", function () {
    mascaraData(this);
});

document.getElementById("cli_cep").addEventListener("input", function () {
    mascaraCEP(this);
});

document.getElementById("cli_telefone").addEventListener("input", function () {
    mascaraTelefone(this);
});