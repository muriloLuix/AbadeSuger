<?php
// Exibir QR Code na tela
session_start();

// Certifique-se de que os dados necessários foram gerados
if (!isset($_SESSION['qrcode']) || !isset($_SESSION['imagemQrcode'])) {
    echo "<p>Erro: QR Code não encontrado.</p>";
    exit;
}

$qrcode = $_SESSION['qrcode'];
$imagemQrcode = $_SESSION['imagemQrcode'];
$valorPagamento = $_SESSION['valorPagamento'] ?? 'Valor não disponível';
$nomeRecebedor = $_SESSION['nomeRecebedor'] ?? 'Recebedor não identificado';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Favicon -->
    <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon">
    <!-- Favicon -->
    <!-- css -->
    <link rel="stylesheet" href="../css/qrcode.css">
    <!-- css -->
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Bootstrap -->
    <title>Abade Suger - Pagamento via Pix</title>
</head>

<body>
    <section class="transparentSection">
        <div class="generalHeader">
            <div class="logo">
                <a href="../../index.php"><img src="../img/logoHeader.svg" alt="Logo Header"></a>
            </div>
            <div class="delivery-info">
                <div class="location">
                    <strong>
                        <span>PAGAMENTO VIA PIX</span>
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
                <div class="icon">
                    <i class="bi bi-newspaper"></i>
                    <span>Notícias</span>
                </div>

            </div>
        </div>
        <div class="container">
            <p class="price"><strong>R$ <?php echo $valorPagamento; ?></strong></p> <!-- Valor do pagamento -->
            <p>Escaneie o QR Code abaixo para realizar o pagamento:</p>
            <p><strong><?php echo $nomeRecebedor; ?></strong></p> <!-- Nome do recebedor -->
            <img src="<?php echo $imagemQrcode; ?>" alt="QR Code Pix">
            <p>Ou copie o código Pix abaixo:</p>
            <textarea readonly><?php echo $qrcode; ?></textarea>
            <a href=""><button class="button-86" role="button">Button 86</button></a>

        </div>
    </section>

</body>

</html>