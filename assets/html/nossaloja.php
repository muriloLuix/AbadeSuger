<?php
session_start();

$client_message = 'Usuário não logado';
$client_id = null;
$cart_count = 0; // Contador de itens no carrinho

if (isset($_SESSION['user_login'])) {
    include('../php/info.php');

    $login = $_SESSION['user_login'];

    // Obtendo informações do cliente
    $query = "SELECT cli_id, cli_cep, cli_cidade FROM clientes WHERE cli_login = :login";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':login', $login, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $client_id = $row['cli_id']; // Obtem o ID do cliente
        $client_cep = $row['cli_cep'];
        $client_cidade = $row['cli_cidade'];
        $client_message = "A entrega será feita em {$client_cidade} ({$client_cep})";

        // Contando os itens no carrinho
        $cart_query = "SELECT COUNT(*) AS total FROM CARRINHO WHERE cli_id = :cli_id";
        $cart_stmt = $pdo->prepare($cart_query);
        $cart_stmt->bindParam(':cli_id', $client_id, PDO::PARAM_INT);
        $cart_stmt->execute();

        if ($cart_stmt->rowCount() > 0) {
            $cart_row = $cart_stmt->fetch(PDO::FETCH_ASSOC);
            $cart_count = $cart_row['total'] ?: 0;
        }

    } else {
        $client_message = 'Informações do endereço não encontradas';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Favicon -->
    <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon">
    <!-- Favicon -->
    <!-- Boostrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <!-- Boostrap -->
    <!-- JavaScript -->
    <script src="../js/carrousel.js" defer></script>
    <script src="../js/filter.js" defer></script>
    <script src="../js/count.js" defer></script>
    <script src="../js/responsitity.js" defer></script>
    <script src="../js/carrinho.js" defer></script>
    <!-- JavaScript -->
    <!-- Css -->
    <link rel="stylesheet" href="../css/loja.css">
    <!-- Css -->
    <title> Loja - Abade Suger</title>
</head>

<body>
    <main>
        <section class="transparentSection">
            <div class="generalHeader">
                <div class="menu-hamburger">
                    <div class="menu-toggle" id="menu-toggle">
                        <div class="hamburger"></div>
                    </div>
                    <div class="menu-overlay" id="menu-overlay">
                        <div class="menu-items">
                            <div class="icon" onclick="redirectToCart()">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-bag" viewBox="0 0 16 16">
                                    <path
                                        d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1m3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1z" />
                                </svg>
                                <span class="badge" id="bag-badge"><?= $cart_count ?></span>
                                <span>Carrinho</span>
                            </div>


                            <?php
                            session_start();
                            require '../php/info.php';

                            $favoritosCount = 0;

                            if (isset($_SESSION['user_id'])) {
                                $userId = $_SESSION['user_id'];
                                echo "User ID: " . $userId . "<br>";

                                try {
                                    $query = "SELECT COUNT(*) as favoritosCount FROM favorito WHERE cli_id = :userId";
                                    $stmt = $pdo->prepare($query);
                                    $stmt->execute(['userId' => $userId]);
                                    $result = $stmt->fetch(PDO::FETCH_ASSOC);

                                    $favoritosCount = $result['favoritosCount'];
                                    echo "Favoritos Count: " . $favoritosCount . "<br>";
                                } catch (PDOException $e) {
                                    echo "Erro ao consultar favoritos: " . $e->getMessage();
                                }
                            } else {
                                echo "Usuário não está logado.<br>";
                            }
                            ?>

                            <div class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-heart" viewBox="0 0 16 16">
                                    <path
                                        d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15" />
                                </svg>
                                <span class="badge" id="favorites-badge"><?php echo $favoritosCount; ?></span>
                                <span>Favoritos</span>
                            </div>

                            <div class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-person" viewBox="0 0 16 16">
                                    <path
                                        d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z" />
                                </svg>
                                <span>Conta</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="logo">
                    <a href="../../index.php"><img src="../img/logoHeader.svg" alt="Logo Header"></a>
                </div>
                <div class="delivery-info">
                    <p><?php echo htmlspecialchars($client_message); ?></p>


                    <div class="location">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-geo-alt" viewBox="0 0 16 16">
                            <path
                                d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A32 32 0 0 1 8 14.58a32 32 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10" />
                            <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4m0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                        </svg>
                        <strong>
                            <a href="">Atualizar CEP</a>
                        </strong>
                    </div>
                </div>
                <div class="dropdown">
                    <button class="dropdown-toggle" type="button">
                        <span class="text">Filtrar:<br /><span class="typeOfFilter">Todos</span></span>
                        <span class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-arrow-down-short" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M8 4a.5.5 0 0 1 .5.5v5.793l2.146-2.147a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 1 1 .708-.708L7.5 10.293V4.5A.5.5 0 0 1 8 4" />
                            </svg>
                        </span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Todos</a></li>
                        <li><a class="dropdown-item" href="#">Menor preço</a></li>
                        <li><a class="dropdown-item" href="#">Maior preço</a></li>
                    </ul>
                </div>


                <div class="search-container">
                    <input type="text" name="search" id="search" placeholder="O que está buscando?">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path fill="#FFFFFF"
                            d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z" />
                    </svg>

                </div>
                <div class="icons">
                    <div class="icon" onclick="redirectToCart()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-bag" viewBox="0 0 16 16">
                            <path
                                d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1m3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1z" />
                        </svg>
                        <span class="badge" id="bag-badge"><?= $cart_count ?></span>
                        <span>Carrinho</span>
                    </div>

                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-heart" viewBox="0 0 16 16">
                            <path
                                d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15" />
                        </svg>
                        <span class="badge" id="favorites-badge">0</span>
                        <span>Favoritos</span>

                        <script>function redirectToCart() {
                                window.location.href = "reviewProduct.php";
                            }</script>
                    </div>
                    <div class="icon">
                        <a href="contacli.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-person" viewBox="0 0 16 16">
                                <path
                                    d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z" />
                            </svg>
                            <span>Conta</span>
                        </a>
                    </div>

                </div>
            </div>

            <div class="carousel">
                <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0"
                            class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                            aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                            aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="../img/NossaLojaBanner.svg" class="d-block w-100" alt="..." />
                        </div>
                        <div class="carousel-item">
                            <img src="../img/backgroundPaginaInicial.png" class="d-block w-100" alt="..." />
                        </div>
                        <div class="carousel-item">
                            <img src="../img/backgroundLojaLight.svg" class="d-block w-100" alt="..." />
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
            <?php
            require '../php/info.php';

            // Query para listar os livros
            $query = "SELECT liv_titulo, liv_preco, liv_id, liv_img FROM LIVROS";
            $stmt = $pdo->prepare($query);

            // Verifica se a execução da consulta foi bem-sucedida
            if ($stmt->execute()) {
                $livros = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                // Caso a consulta falhe, atribui um array vazio e exibe uma mensagem de erro
                $livros = [];
                echo "Erro ao executar a consulta SQL.";
            }

            // Verifica se um id de livro foi passado na URL
            $livro_id = isset($_GET['id']) ? $_GET['id'] : null;

            $livro = null; // Inicializa a variável $livro
            
            if ($livro_id) {
                // Query para obter detalhes do livro específico
                $queryLivro = "SELECT liv_pag, liv_preco, liv_img, liv_titulo, liv_id FROM LIVROS WHERE liv_id = :livro_id";
                $stmtLivro = $pdo->prepare($queryLivro);
                $stmtLivro->bindParam(':livro_id', $livro_id, PDO::PARAM_INT);
                $stmtLivro->execute();

                // Verifica se algum livro foi encontrado
                $livro = $stmtLivro->fetch(PDO::FETCH_ASSOC);
            }
            ?>

            <div class="cardContainer">
                <?php if (!empty($livros)): ?>
                    <?php foreach ($livros as $livroItem): ?>
                        <div class="card">
                            <div class="card-header">
                                <span class="favorite-icon" data-livro-id="<?php echo $livroItem['liv_id']; ?>">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path id="favorite-icon-<?php echo $livroItem['liv_id']; ?>"
                                            d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"
                                            fill="#3E30AB" />
                                    </svg>
                                </span>
                                <span class="info-icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12" r="10" stroke="#3E30AB" stroke-width="2" />
                                        <path d="M12 16v-4" stroke="#3E30AB" stroke-width="2" stroke-linecap="round" />
                                        <circle cx="12" cy="8" r="1" fill="#3E30AB" />
                                    </svg>
                                </span>
                            </div>

                            <!-- Exibição da imagem com verificação -->
                            <?php if (!empty($livroItem['liv_img'])): ?>
                                <?php

                                $imagemPath = htmlspecialchars($livroItem['liv_img']);
                                $imagemPath = str_replace("../../assets/img/capalivro/", "../img/capalivro/", $imagemPath);
                                ?>
                                <img src="<?php echo $imagemPath; ?>" alt="Imagem do livro" class="book-image">

                            <?php else: ?>
                                <p>Imagem não disponível.</p>
                            <?php endif; ?>

                            <!-- Exibição do título e preço do livro -->
                            <h1 class="product-name"><?php echo htmlspecialchars($livroItem['liv_titulo']); ?></h1>
                            <p class="product-price">R$ <?php echo number_format($livroItem['liv_preco'], 2, ',', '.'); ?></p>
                            <a href="descriptionProduct.php?id=<?php echo $livroItem['liv_id']; ?>" class="description-button">
                                Informações
                            </a>
                            <a href="javascript:void(0);" class="buy-button" data-livro-id="<?php echo $livroItem['liv_id']; ?>"
                                data-cli-id="<?php echo $client_id; ?>" data-liv-preco="<?php echo $livroItem['liv_preco']; ?>">
                                Comprar
                            </a>



                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Nenhum produto encontrado.</p>
                <?php endif; ?>
            </div>

            <script>
                // Verifica quando o ícone de favorito for clicado
                document.querySelectorAll('.favorite-icon').forEach(item => {
                    item.addEventListener('click', function () {
                        let livroId = this.getAttribute('data-livro-id'); // ID do livro
                        let iconId = 'favorite-icon-' + livroId;
                        let userId = <?php echo $_SESSION['user_id']; ?>; // ID do usuário logado
                        let action = document.getElementById(iconId).classList.contains('favoritado') ? 'remove' : 'add'; // Verifica se já está favoritado

                        // Faz a requisição AJAX para adicionar ou remover o favorito
                        fetch('../php/processar_favorito.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({ userId: userId, livroId: livroId, action: action })
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.status === 'success') {
                                    if (action === 'add') {
                                        document.getElementById(iconId).classList.add('favoritado');
                                    } else {
                                        document.getElementById(iconId).classList.remove('favoritado');
                                    }
                                    // Atualiza o contador de favoritos na página de favoritos
                                    document.getElementById('favorites-badge').textContent = data.favoritosCount;
                                } else {
                                    alert('Ocorreu um erro ao adicionar aos favoritos');
                                }
                            })
                            .catch(error => console.error('Erro ao processar favorito:', error));
                    });
                });
            </script>


        </section>
    </main>

</body>

</html>