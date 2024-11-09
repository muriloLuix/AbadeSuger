function showPassword() {
    let inputPass = document.getElementById('cli_senha');
    let btnShowPass = document.getElementById('btnPassword');

    if (inputPass.type === 'password') {
        inputPass.setAttribute('type', 'text');
        btnShowPass.classList.replace('bi-eye-fill', 'bi-eye-slash-fill'); // Muda o ícone para olho fechado
    } else {
        inputPass.setAttribute('type', 'password');
        btnShowPass.classList.replace('bi-eye-slash-fill', 'bi-eye-fill'); // Muda o ícone para olho aberto
    }
}