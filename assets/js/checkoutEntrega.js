document.getElementById("semEntrega").addEventListener("change", function () {
    const isChecked = this.checked;
    const camposEntrega = document.querySelectorAll("#entregaCampos input");

    camposEntrega.forEach((campo) => {
        campo.disabled = isChecked; // Desabilita os campos se o checkbox estiver marcado
    });

    if (isChecked) {
        document.getElementById("cep").removeAttribute("required");
        document.getElementById("numero").removeAttribute("required");
    } else {
        document.getElementById("cep").setAttribute("required", "required");
        document.getElementById("numero").setAttribute("required", "required");
    }
});
