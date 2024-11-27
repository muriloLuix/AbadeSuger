<?php
// Conexão com o banco de dados
include '../php/info.php'; // Ajuste para o arquivo de configuração de conexão com o banco

// Verificar se o ID foi passado na URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $noticia_id = intval($_GET['id']); // Segurança: Garantir que o ID seja numérico

    // Query para buscar a notícia pelo ID
    $query = "SELECT not_titulo, not_resumo, not_desc, not_resp, not_dtcriacao, not_dtatualizacao, not_img 
              FROM noticias 
              WHERE not_id = :noticia_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':noticia_id', $noticia_id, PDO::PARAM_INT);
    $stmt->execute();
    $noticia = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar se a notícia foi encontrada
    if (!$noticia) {
        echo "Notícia não encontrada.";
        exit;
    }
} else {
    echo "ID da notícia não foi fornecido.";
    exit;
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
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Bootstrap -->
    <!-- Css -->
    <link rel="stylesheet" href="../css/noticiaCompleta.css">
    <!-- Css -->
    <title>Abade Suger - Título da notícia</title>
</head>

<body>
    <div class="generalHeader">
        <div class="logo">
            <a href="../../index.php"><img src="../img/logoHeader.svg" alt="Logo Header"></a>
        </div>
        <div class="delivery-info">
            <div class="location">
                <strong>
                    <span>Notícia</span>
                </strong>
            </div>
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
                    class="bi bi-calendar" viewBox="0 0 16 16">
                    <path
                        d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z" />
                </svg>
                <span>Calendário</span>
            </div>
            <div class="icon">
                <i class="bi bi-newspaper"></i>
                <span>Notícias</span>
            </div>

        </div>
    </div>
    <div class="container">
        <header>
            <h1><?php echo htmlspecialchars($noticia['not_titulo']); ?></h1>
        </header>
        <section>
            <p class="subheadline">
                <?php echo htmlspecialchars($noticia['not_resumo']); ?>
            </p>
        </section>
        <div class="article-meta">
            <p>Matéria dirigida pelo(a) <span
                    class="responsavel"><?php echo htmlspecialchars($noticia['not_resp']); ?></span></p>
            <p>
                <?php echo date('d/m/Y', strtotime($noticia['not_dtcriacao'])); ?> &nbsp;&nbsp;
                <?php
                if (!empty($noticia['not_dtatualizacao'])) {
                    $atualizacao = date('d/m/Y H:i', strtotime($noticia['not_dtatualizacao']));
                    echo "Atualizado em $atualizacao";
                }
                ?>
            </p>
        </div>
        <main>
            <p>
                <?php echo nl2br(htmlspecialchars($noticia['not_desc'])); ?>
            </p>
            <figure>
                <img src="<?php echo htmlspecialchars($noticia['not_img']); ?>" alt="Imagem da notícia">
                <figcaption>Imagem relacionada à notícia.</figcaption>
            </figure>
        </main>

        <footer>
            <div class="location">
                <p>25°32'39.21"S &nbsp;&nbsp; 49°23'06.21"W</p>
            </div>
            <div class="social-links">
                <a href="#"><i class="bi bi-facebook"></i></a>
                <a href="#"><i class="bi bi-twitter-x"></i></a>
                <a href="#"><i class="bi bi-whatsapp"></i></a>
                <a href="#"><i class="bi bi-share"></i></a>
            </div>
        </footer>
    </div>
</body>

</html>