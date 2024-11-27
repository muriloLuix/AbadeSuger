document.querySelector(".button-finish button").addEventListener("click", function (e) {
    e.preventDefault();
    const formData = new FormData(document.querySelector("form")); // Coleta os dados do formulário

    fetch("../php/gerar_pix.php", {
        method: "POST",
        body: formData,
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                document.querySelector("#content4").innerHTML = `
                    <h3>Escaneie o QR Code abaixo para pagar com Pix</h3>
                    <img src="${data.qrcode}" alt="QR Code do Pix">
                    <p>Ou copie e cole este código no app do seu banco:</p>
                    <p>${data.pixLink}</p>
                `;
            } else {
                alert("Erro ao gerar o QR Code: " + data.message);
            }
        })
        .catch(error => console.error("Erro na solicitação:", error));
});
