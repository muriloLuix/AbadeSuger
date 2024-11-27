
document.querySelectorAll(".tab-button").forEach(button => {
    button.addEventListener("click", () => {
        const targetId = button.getAttribute("data-target");

        // Remove "active" de todos os botões e painéis
        document.querySelectorAll(".tab-button").forEach(btn => btn.classList.remove("active"));
        document.querySelectorAll(".tab-panel").forEach(panel => panel.classList.remove("active"));

        // Adiciona "active" ao botão e ao painel selecionado
        button.classList.add("active");
        document.getElementById(targetId).classList.add("active");
    });
});

document.querySelectorAll('.thumbnail').forEach(item => {
    item.addEventListener('click', function () {
        const targetImage = item.getAttribute('data-target');
        document.getElementById('slider').src = targetImage;
    });
});
