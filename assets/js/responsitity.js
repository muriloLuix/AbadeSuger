document.addEventListener('DOMContentLoaded', function () {
    const menuToggle = document.getElementById('menu-toggle');
    const menuOverlay = document.getElementById('menu-overlay');

    menuToggle.addEventListener('click', function () {
        menuToggle.classList.toggle('active');
        menuOverlay.classList.toggle('active');
    });
});
