function addBlinkEffect(element) {
    element.classList.add('blink');
    setTimeout(() => {
        element.classList.remove('blink');
    }, 500); // O tempo deve corresponder à duração da animação
}

// Adicionar eventos a todos os ícones de favoritos
document.querySelectorAll('.favorite-icon').forEach(icon => {
    icon.addEventListener('click', function () {
        const badge = document.getElementById('favorites-badge');
        let count = parseInt(badge.textContent, 10);
        badge.textContent = count + 1; // Incrementa o número
        addBlinkEffect(badge);
    });
});

// Adicionar eventos a todos os botões de compra
document.querySelectorAll('.buy-button').forEach(button => {
    button.addEventListener('click', function () {
        const badge = document.getElementById('bag-badge');
        let count = parseInt(badge.textContent, 10);
        badge.textContent = count + 1; // Incrementa o número
        addBlinkEffect(badge);
    });
});
