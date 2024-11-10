// Verifica o status na URL
const urlParams = new URLSearchParams(window.location.search);
const status = urlParams.get('status');

// Exibe o modal se o status for "success"
if (status === 'success') {
    const modal = document.getElementById("successModal");
    modal.style.display = "flex";
}

// Fecha o modal quando clicar no "X"
document.getElementById("closeModal").onclick = function() {
    document.getElementById("successModal").style.display = "none";
}

// Fecha o modal se clicar fora da área do modal
window.onclick = function(event) {
    if (event.target == document.getElementById("successModal")) {
        document.getElementById("successModal").style.display = "none";
    }
}
