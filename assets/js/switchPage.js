
// Função para alternar as telas
function showAfterContainer() {
    document.getElementById('blackTransparent').style.display = 'none';
    document.getElementById('blackTransparentAfter').style.display = 'block';
}

// Listener para o login com Google
document.getElementById('login-google').addEventListener('click', function (event) {
    event.preventDefault(); // Evita que o link padrão seja acionado
    showAfterContainer();
});

// Listener para o envio do formulário
document.getElementById('login-form').addEventListener('submit', function (event) {
    event.preventDefault(); // Evita o envio padrão do formulário
    // Aqui você pode adicionar lógica de validação e, se necessário, enviar dados via AJAX
    showAfterContainer(); // Alterna para a próxima tela
});


document.addEventListener('DOMContentLoaded', () => {
    const selectElement = document.getElementById('month');
    const labelElement = selectElement.nextElementSibling;

    function toggleLabelVisibility() {
        if (selectElement.value) {
            labelElement.classList.add('hidden-label');
        } else {
            labelElement.classList.remove('hidden-label');
        }
    }

    selectElement.addEventListener('change', toggleLabelVisibility);
    // Inicializa a visibilidade da label
    toggleLabelVisibility();

    function updateOptionStyles() {
        const options = selectElement.options;
        for (let i = 0; i < options.length; i++) {
            if (options[i].selected) {
                options[i].style.color = '#fff';
            } else {
                options[i].style.color = '#000';
            }
        }
    }
    selectElement.addEventListener('change', updateOptionStyles);

    updateOptionStyles();
});
