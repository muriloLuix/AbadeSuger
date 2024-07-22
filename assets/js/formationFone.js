document.getElementById('phone').addEventListener('input', function (e) {
    let input = e.target.value;
    input = input.replace(/\D/g, '');
    let formatted = '';

    if (input.length > 0) {
        formatted += `(${input.slice(0, 2)}`;
    }
    if (input.length > 2) {
        formatted += `) ${input.slice(2, 7)}`;
    }
    if (input.length > 7) {
        formatted += ` - ${input.slice(7, 11)}`;
    }
    e.target.value = formatted;
});