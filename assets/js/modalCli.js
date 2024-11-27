
document.getElementById("editButton").addEventListener("click", function () {
    document.getElementById("editModal").classList.remove("hidden");
});

document.getElementById("closeModal").addEventListener("click", function () {
    document.getElementById("editModal").classList.add("hidden");
});

// Fecha o modal se clicar fora do conteúdo
window.addEventListener("click", function (event) {
    const modal = document.getElementById("editModal");
    if (event.target === modal) {
        modal.classList.add("hidden");
    }
});