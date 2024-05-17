window.addEventListener('load', function () {
    setTimeout(function () {
        document.querySelector('.loader-wrapper').style.display = 'none';
    }, 2500);
});

const elemento = document.querySelector('.general');

setTimeout(() => {
    elemento.classList.add('animate');
}, 2550);

document.addEventListener("DOMContentLoaded", () => {
  const bannerInner = document.querySelector(".banner-inner");
  const bannerItems = document.querySelectorAll(".banner-item");
  const totalItems = bannerItems.length;
  let index = 0;
  let interval = setInterval(showNextSlide, 5000);

  function showNextSlide() {
    index = (index + 1) % totalItems;
    updateBanner();
  }

  function showPrevSlide() {
    index = (index - 1 + totalItems) % totalItems;
    updateBanner();
  }

  function updateBanner() {
    bannerInner.style.transform = `translateX(-${index * 100}%)`;
  }

  document.querySelector(".next").addEventListener("click", () => {
    clearInterval(interval);
    showNextSlide();
    interval = setInterval(showNextSlide, 5000);
  });

  document.querySelector(".prev").addEventListener("click", () => {
    clearInterval(interval);
    showPrevSlide();
    interval = setInterval(showNextSlide, 5000);
  });
});
