document.getElementById('adicionarAgendaBtn').addEventListener('click', async function () {
    const form = document.getElementById('formAdicionarAgenda');
    const formData = new FormData(form);

    try {
        const response = await fetch('../php/adicionar_agenda.php', {
            method: 'POST',
            body: formData
        });

        const result = await response.text(); // Apenas obter a resposta como texto

        if (result.trim() === 'success') {
            alert('Notícia adicionada à sua agenda com sucesso!');
            window.location.reload(); // Recarregar a página após sucesso
        } else {
            alert('Erro ao adicionar à agenda: ' + result);
        }
    } catch (error) {
        alert('Erro ao adicionar à agenda: ' + error.message);
    }
});
