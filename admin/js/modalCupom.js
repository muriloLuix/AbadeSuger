// Seleciona os elementos
const modalCupom = document.getElementById('modalCupom');
const btnAbrirModal = document.getElementById('btnAbrirModalCupom');
const spanClose = document.querySelector('.closeCupom');

// Abrir o modal
btnAbrirModal.onclick = function () {
    modalCupom.style.display = 'block';
}

// Fechar o modal ao clicar no "X"
spanClose.onclick = function () {
    modalCupom.style.display = 'none';
}

// Fechar o modal ao clicar fora dele
window.onclick = function (event) {
    if (event.target === modalCupom) {
        modalCupom.style.display = 'none';
    }
}

// Submeter o formulário via AJAX
document.getElementById('formCupom').addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    const xhr = new XMLHttpRequest();
    xhr.open('POST', this.action, true);

    xhr.onload = function () {
        if (xhr.status === 200) {
            if (xhr.responseText.trim() === 'success') {
                alert('Cupom cadastrado com sucesso!');
                modalCupom.style.display = 'none';

                // Recarrega a tabela de cupons para mostrar o novo cupom
                reloadCupomTable();
            } else {
                alert('Erro ao cadastrar o cupom.');
            }
        } else {
            alert('Erro na requisição.');
        }
    };

    xhr.send(formData);
});

// Função para recarregar a tabela de cupons
function reloadCupomTable() {
    const tabelaCupons = document.querySelector('#tabelaCupons tbody');

    // Cria a requisição para atualizar a tabela
    const xhr = new XMLHttpRequest();
    xhr.open('GET', '../php/get_cupons.php', true); // O arquivo PHP que retorna os cupons cadastrados

    xhr.onload = function () {
        if (xhr.status === 200) {
            // Atualiza o conteúdo da tabela
            tabelaCupons.innerHTML = xhr.responseText;
        } else {
            alert('Erro ao recarregar a tabela de cupons.');
        }
    };

    xhr.send();
}
