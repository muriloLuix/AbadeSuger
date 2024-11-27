document.addEventListener("DOMContentLoaded", () => {
    const radioPayPal = document.getElementById("radio1");
    const radioCreditCard = document.getElementById("radio2");
    const radioPix = document.getElementById("radio3");

    const formPayPal = document.getElementById("formPayPal");
    const formCreditCard = document.getElementById("formCreditCard");

    const toggleForms = () => {
        if (radioPix.checked) {
            formPayPal.style.display = "none";
            formCreditCard.style.display = "none";
        } else if (radioPayPal.checked && !radioPayPal.disabled) {
            formPayPal.style.display = "block";
            formCreditCard.style.display = "none";
        } else if (radioCreditCard.checked && !radioCreditCard.disabled) {
            formPayPal.style.display = "none";
            formCreditCard.style.display = "block";
        }
    };

    // Adiciona evento aos rádios
    radioPayPal.addEventListener("change", toggleForms);
    radioCreditCard.addEventListener("change", toggleForms);
    radioPix.addEventListener("change", toggleForms);

    // Inicializa com o método padrão selecionado (Pix)
    toggleForms();
});