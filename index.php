<?php

include('assets/php/info.php');

$query = "SELECT liv_titulo FROM livros";
$stmt = $pdo->prepare($query);
$stmt->execute();

$livros = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Boostrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <!-- Boostrap -->
  <!-- Scripts -->
  <script src="assets/js/hoverEffect.js" defer></script>
  <script src="assets/js/carrousel.js" defer></script>
  <script src="assets/js/dropdown.js" defer></script>
  <script src="assets/js/menu.js" defer></script>
  <script src="assets/js/cardContainer.js" defer></script>
  <!-- Scripts -->
  <!-- Favicon -->
  <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon" />
  <!-- Favicon -->
  <!-- Css -->
  <link rel="stylesheet" href="assets/css/style.css" />
  <!-- Css -->
  <title>Abade Suger - Editora</title>
</head>

<body>
  <section class="transparentSection">
    <!-- Menu Celular -->
    <div class="orange">
      <img src="assets/img/logoMenu.svg" alt="Logo Menu" id="dropdown-btn">
    </div>
    <div class="dropdown" id="dropdown-menu">
      <button class="close-btn" id="close-menu">&times;</button>
      <div class="inspiracoes">
        <span>Inspirações</span>
        <a href="assets/html/nossasinspiracoes.html" class="dropdown-item"><img src="assets/img/arvoreSvg.svg"
            alt="Nossas Inspirações"></a>
      </div>
      <hr class="lineMenu">
      <div class="lojaMenu">
        <span>Loja</span>
        <a href="assets/html/nossaloja.php" class="dropdown-item"><img src="assets/img/shopping-bag.svg"
            alt="Nossa loja"></a>
      </div>
      <hr class="lineMenu">
      <div class="agendaMenu">
        <span>Agenda</span>
        <a href="assets/html/noticias.php" class="dropdown-item"><img src="assets/img/calendar.svg"
            alt="Agenda e Notícias"></a>
      </div>
      <hr class="lineMenu">
      <div class="publiqueObraMenu">
        <span>Publique sua<br>Obra</span>
        <a href="assets/html/publiquesuaobra.html" class="dropdown-item"><img src="assets/img/lamp.svg"
            alt="Publicar uma obra"></a>
      </div>
      <hr class="lineMenu">
      <div class="indiqueUmaObraMenu">
        <span>Indique uma<br> Obra</span>
        <a href="assets/html/indiqueumaobra.html" class="dropdown-item"><img src="assets/img/lupa.svg"
            alt="Indique uma obra"></a>
      </div>
      <hr class="lineMenu">
      <div class="contaMenu">
        <span>Conta</span>
        <a href="assets/html/contacli.php" class="dropdown-item"><img src="assets/img/user.svg" alt="Conta"></a>
      </div>
    </div>

    <header>
      <div class="carousel">
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
              aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
              aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
              aria-label="Slide 3"></button>
          </div>
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="assets/img/bannerInicial.svg" class="d-block w-100" alt="..." />
            </div>
            <div class="carousel-item">
              <img src="assets/img/novoLançamento.svg" class="d-block w-100" alt="..." />
            </div>
            <div class="carousel-item">
              <img src="assets/img/mulherNoChao.jpg" class="d-block w-100" alt="..." />
            </div>
          </div>

          <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
      </div>
      <div class="generalHeader">
        <div class="logo" id="logo">
          <img src="assets/img/logoHeader.svg" alt="Logo Abade" />
          <div class="hamburger" id="hamburger">
            <span></span>
            <span></span>
            <span></span>
          </div>
        </div>
        <div class="navigation" id="nav">
          <nav>
            <ul>
              <li><a href="#">HOME<span class="animation"></span></a></li>
              <li><a href="#">QUEM SOMOS<span class="animation"></span></a></li>
              <li><a href="assets/html/register.html">REGISTRE-SE<span class="animation"></span></a></li>
              <li><a href="assets/html/noticias.php">AGENDA<span class="animation"></span></a></li>
              <li><a href="assets/html/nossaloja.php">LOJA<span class="animation"></span></a></li>
              <li><a href="contato/contato.php">CONTATO<span class="animation"></span></a></li>
            </ul>
          </nav>
        </div>
      </div>
    </header>
    <div class="card-container">
      <a href="assets/html/nossasinspiracoes.html" class="card-link">
        <div class="card card-1">Nossas<br> Inspirações</div>
      </a>
      <a href="assets/html/nossaloja.php" class="card-link">
        <div class="card card-2">Nossa <br>Loja</div>
      </a>
      <a href="assets/html/noticias.php" class="card-link">
        <div class="card card-3">Notícias e<br>Agenda</div>
      </a>
      <a href="assets/html/publiquesuaobra.html" class="card-link">
        <div class="card card-4">Quer <br>Publicar <br>Uma Obra?</div>
      </a>
      <a href="assets/html/indiqueumaobra.html" class="card-link">
        <div class="card card-6">Indique <br>Uma Obra</div>
      </a>
    </div>
  </section>
</body>

</html>