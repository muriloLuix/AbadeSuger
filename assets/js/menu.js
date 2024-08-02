document.addEventListener('DOMContentLoaded', function () {
    const hamburger = document.getElementById('hamburger');
    const fullScreenMenu = document.getElementById('fullScreenMenu');
    const closeButton = document.getElementById('closeButton');
    const logo = document.getElementById('logo');
    const menuLinks = document.querySelectorAll('.full-screen-menu nav ul li a');

    function closeMenu() {
        fullScreenMenu.classList.remove('active');
        hamburger.classList.remove('active');
        logo.classList.remove('expanded');
        document.body.style.overflow = 'auto';
        setTimeout(() => {
            fullScreenMenu.style.display = 'none';
        }, 500);
    }

    hamburger.addEventListener('click', function () {
        hamburger.classList.toggle('active');
        logo.classList.toggle('expanded');
        if (fullScreenMenu.classList.contains('active')) {
            closeMenu();
        } else {
            fullScreenMenu.style.display = 'flex';
            setTimeout(() => {
                fullScreenMenu.classList.add('active');
            }, 10);
            document.body.style.overflow = 'hidden';
        }
    });

    closeButton.addEventListener('click', function () {
        closeMenu();
    });

    menuLinks.forEach(function (link) {
        link.addEventListener('click', function () {
            closeMenu();
        });
    });
});
