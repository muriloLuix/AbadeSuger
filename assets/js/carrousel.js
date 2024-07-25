document.addEventListener("DOMContentLoaded", function () {
  const carouselSlide = document.querySelector(".carousel-slide");
  const carouselItems = document.querySelectorAll(".carousel-item");
  const totalItems = carouselItems.length;
  const slideWidth = carouselSlide.clientWidth;
  let counter = 0;
  const slideInterval = 1000 * 5;

  carouselSlide.style.width = `${totalItems * slideWidth}px`;

  function nextSlide() {
    counter++;
    if (counter >= totalItems) {
      counter = 0;
    }
    carouselSlide.style.transform = `translateX(-${counter * slideWidth}px)`;
  }

  // Adicione a transição suave aqui
  carouselSlide.style.transition = "transform 0.5s ease-in-out";

  // Defina o intervalo para mudar o slide automaticamente
  setInterval(nextSlide, slideInterval);

  const prevBtn = document.querySelector(".carousel-prev");
  const nextBtn = document.querySelector(".carousel-next");

  prevBtn.addEventListener("click", () => {
    counter--;
    if (counter < 0) {
      counter = totalItems - 1;
    }
    carouselSlide.style.transform = `translateX(-${counter * slideWidth}px)`;
  });

  nextBtn.addEventListener("click", () => {
    nextSlide();
  });
});
