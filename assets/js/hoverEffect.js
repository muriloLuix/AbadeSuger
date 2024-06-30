var el = document.getElementById("el");
var nav = document.getElementById("nav");

var elWidth = el.offsetWidth;
var elHeight = el.offsetHeight;
var width = window.innerWidth;
var height = window.innerHeight;
var target = {
  x: width / 2,
  y: height / 2,
};
var position = {
  x: height,
  y: width,
};
var ease = 0.075;
var scaleRatio = 4; // Fator de escala para aumentar o tamanho da bola

nav.addEventListener("mouseenter", function () {
  el.style.opacity = 1;
  window.addEventListener("mousemove", mousemoveHandler);
});

nav.addEventListener("mouseleave", function () {
  el.style.opacity = 0;
  el.style.transform = "scale(1)";
  window.removeEventListener("mousemove", mousemoveHandler);
});

nav.querySelectorAll("li").forEach(function (item) {
  item.addEventListener("mouseenter", function () {
    // Obtém a posição do texto do menu
    var rect = item.getBoundingClientRect();
    var itemCenterX = rect.left + rect.width / 2;
    var itemCenterY = rect.top + rect.height / 2;

    // Define a posição da bola atrás do texto do menu
    target.x = itemCenterX;
    target.y = itemCenterY;

    // Aumenta o tamanho da bola
    el.style.transform = `scale(${scaleRatio})`;
  });

  item.addEventListener("mouseleave", function () {
    el.style.transform = "scale(1)";
  });
});

function mousemoveHandler(event) {
  target.x = event.clientX;
  target.y = event.clientY;
}

function update() {
  var dx = target.x - position.x;
  var dy = target.y - position.y;
  var vx = dx * ease;
  var vy = dy * ease;

  position.x += vx;
  position.y += vy;

  el.style.left = (position.x - elWidth / 2).toFixed() + "px";
  el.style.top = (position.y - elHeight / 2).toFixed() + "px";

  requestAnimationFrame(update);
}

update();
