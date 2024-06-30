document.addEventListener("DOMContentLoaded", function() {
    const carouselSlide = document.querySelector(".carousel-slide");
    const carouselItems = document.querySelectorAll(".carousel-item");
  
    // Configurações iniciais
    let counter = 0;
    const totalItems = carouselItems.length;
    const slideWidth = carouselSlide.clientWidth; // Largura de um slide
  
    // Ajusta a largura do slide conforme o número de itens
    carouselSlide.style.width = `${totalItems * slideWidth}px`;
  
    // Botões de navegação
    const prevBtn = document.querySelector(".carousel-prev");
    const nextBtn = document.querySelector(".carousel-next");
  
    // Navegação para o slide anterior
    prevBtn.addEventListener("click", () => {
      counter--;
      if (counter < 0) {
        counter = totalItems - 1;
      }
      carouselSlide.style.transform = `translateX(-${counter * slideWidth}px)`;
    });
  
    // Navegação para o próximo slide
    nextBtn.addEventListener("click", () => {
      counter++;
      if (counter >= totalItems) {
        counter = 0;
      }
      carouselSlide.style.transform = `translateX(-${counter * slideWidth}px)`;
    });
});
