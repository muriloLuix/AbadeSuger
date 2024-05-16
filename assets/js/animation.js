window.addEventListener('load', function () {
    setTimeout(function () {
        document.querySelector('.loader-wrapper').style.display = 'none';
    }, 2500);
});

const elemento = document.querySelector('.general');

setTimeout(() => {
    elemento.classList.add('animate');
}, 2515);
