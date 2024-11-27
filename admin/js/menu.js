document.addEventListener('DOMContentLoaded', function () {
    // Seções
    const sections = document.querySelectorAll('.mainContent > div');
    const links = document.querySelectorAll('.slidebar a');

    // Função para mostrar a seção ativa
    function showSection(targetId) {
        sections.forEach(section => {
            if (section.id === targetId) {
                section.classList.remove('hidden'); // Mostrar a seção clicada
            } else {
                section.classList.add('hidden'); // Esconder as outras seções
            }
        });
    }

    // Adicionar evento de clique nos links da barra lateral
    links.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            const targetId = link.getAttribute('href').substring(1); // Remover o "#" do href
            showSection(targetId);
        });
    });

    // Mostrar a seção inicial (por exemplo, "perfil")
    showSection('perfil');
});
