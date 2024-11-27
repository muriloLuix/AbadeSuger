<?php
session_start();
require '../php/info.php';

// Verifique se o usuário está logado
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    // Consultar os livros que o usuário marcou como favoritos
    $query = "SELECT livros.liv_id, livros.liv_titulo, livros.liv_preco
    FROM favorito 
    INNER JOIN livros ON favorito.liv_id = livros.liv_id 
    WHERE favorito.cli_id = :userId";

    $stmt = $pdo->prepare($query);
    $stmt->execute(['userId' => $userId]);
    $favoritos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $favoritos = [];
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/favoritos.css">
    <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon">
    <title>Favoritos - Abade Suger</title>
</head>

<body>
    <header>
        <div class="container">
            <div class="logoFavoritos">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-heart" viewBox="0 0 16 16" id="heart-icon">
                        <path
                            d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15" />
                    </svg>
                    <span class="badge" id="favorites-badge"><?php echo count($favoritos); ?></span>
                    <span>Favoritos</span>
                </div>
            </div>
        </div>
    </header>
    <main>
        <div class="cardContainer">
            <?php if (empty($favoritos)): ?>
                <p>Você ainda não tem favoritos.</p>
            <?php else: ?>
                <?php foreach ($favoritos as $livro): ?>
                    <div class="card">
                        <div class="card-header">
                            <span class="favorite-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"
                                        fill="#3E30AB" />
                                </svg>
                            </span>
                        </div>
                        <img src="../img/<?php echo htmlspecialchars($livro['liv_imagem']); ?>" alt="Imagem do livro"
                            class="book-image">
                        <h1 class="product-name"><?php echo htmlspecialchars($livro['liv_titulo']); ?></h1>
                        <p class="product-price">R$ <?php echo number_format($livro['liv_preco'], 2, ',', '.'); ?></p>
                        <button class="buy-button">Comprar</button>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>
</body>

</html>