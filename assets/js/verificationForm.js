document.addEventListener('DOMContentLoaded', () => {
    const inputs = document.querySelectorAll('.input-group input, .input-group textarea');

    inputs.forEach(input => {
        function updateLabel() {
            if (input.value.trim() !== '') {
                input.classList.add('has-value');
            } else {
                input.classList.remove('has-value');
            }
        }

        input.addEventListener('input', updateLabel);

        input.addEventListener('blur', updateLabel);

        input.addEventListener('focus', () => {
            input.classList.add('has-value');
        });

        updateLabel();
    });
});
