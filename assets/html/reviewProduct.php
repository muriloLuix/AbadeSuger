<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    // Renderiza um modal em vez de apenas mostrar a mensagem
    echo '
    <head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    </head>
    
    <div id="loginModalLoginNaoRealizado" class="modalLoginNaoRealizado">
        <div class="modal-contentLoginNaoRealizado">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="bi bi-x-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                <path
                    d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
            </svg>
            <p>Você precisa estar logado para acessar o carrinho.</p>
            <button onclick="redirectToLogin()" class="btn-excluir-edicao-noticiaLoginNaoRealizado">Fazer Login</button>
            <button type="button" id="closeModalLoginNaoRealizado" class="btn-cancelarLoginNaoRealizado">Cancelar</button>
        </div>
    </div>
    <script>
        // Redireciona para a página de login
        function redirectToLogin() {
            window.location.href = "login.php";
        }

        // Fecha o modal
        document.getElementById("closeModalLoginNaoRealizado").addEventListener("click", function () {
            const modal = document.getElementById("loginModalLoginNaoRealizado");
            modal.style.display = "none";
        });
    </script>
    <style>
        .modalLoginNaoRealizado {
            display: flex;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #312682;
            justify-content: center;
            align-items: center;
        }
        .modal-contentLoginNaoRealizado {
            background-color: #ffff;
            margin: 17% auto;
            padding: 20px;
            border-radius: 10px;
            width: 15%;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .modal-contentLoginNaoRealizado button {
            margin: 10px;
            font-family: "Montserrat", sans-serif;
        }
        .btn-excluir-edicao-noticiaLoginNaoRealizado {
            background-color: #3E30AB;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-excluir-edicao-noticiaLoginNaoRealizado:hover{
            background-color: #513de1;
        }
        .btn-cancelarLoginNaoRealizado {
            background-color: #6c757d;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-cancelarLoginNaoRealizado:hover {
            background-color: lightgray;
        }

        .modal-contentLoginNaoRealizado svg {
            width: 9vw;
            background-color: #3e30ab3a;
            padding: 3%;
            height: 19vh;
            border-radius: 156px;
        }

        .modal-contentLoginNaoRealizado path {
            color: #3E30AB;
        }

        .modal-contentLoginNaoRealizado p {
            font-family: "Montserrat", sans-serif;
        }

    </style>';
    exit;
}

$cli_id = $_SESSION['user_id'];

require '../php/info.php';

try {
    // Consulta para obter itens do carrinho
    $queryCarrinho = "
SELECT
carrinho.car_id AS carrinho_id,
carrinho.cli_id,
carrinho.liv_id,
carrinho.liv_preco,
livros.liv_titulo,
livros.liv_img,
autor.aut_nome,
editora.edi_nome,
carrinho.car_quantidade
FROM carrinho
JOIN livros ON carrinho.liv_id = livros.liv_id
JOIN autor ON livros.aut_id = autor.aut_id
JOIN editora ON livros.edi_id = editora.edi_id
WHERE carrinho.cli_id = :cli_id
";

    $stmtCarrinho = $pdo->prepare($queryCarrinho);
    $stmtCarrinho->bindParam(':cli_id', $cli_id, PDO::PARAM_INT);
    $stmtCarrinho->execute();

    $itensCarrinho = $stmtCarrinho->fetchAll(PDO::FETCH_ASSOC);

    if (empty($itensCarrinho)) {
        $subtotal = 0;
    } else {
        // Calcula o subtotal
        $subtotal = 0;
        foreach ($itensCarrinho as $item) {
            $livroPreco = floatval($item['liv_preco']);
            $quantidade = isset($item['car_quantidade']) ? intval($item['car_quantidade']) : 1;
            $subtotal += $livroPreco * $quantidade;
        }
    }

} catch (PDOException $e) {
    echo "Erro ao buscar itens do carrinho: " . $e->getMessage();
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <!-- Script -->
    <script src="../js/inputCep.js" defer></script>
    <script src="../js/cupom.js" defer></script>
    <script src="../js/remover_carrinho.js" defer></script>
    <script src="../js/atualizar_carrinho.js" defer></script>
    <script src="../js/viacep.js" defer></script>
    <!-- Script -->
    <!-- Css -->
    <link rel="stylesheet" href="../css/reviewProduct.css">
    <!-- Css -->
    <title>Abade Suger - Meu carrinho</title>
</head>

<body>
    <main>
        <section class="transparentSection">
            <div class="generalHeader">
                <div class="logo" id="logo">
                    <img src="../img/logoHeader.svg" alt="Logo Abade" />
                    <div class="hamburger" id="hamburger">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
                <div class="navigation" id="nav">
                    <nav>
                        <ul>
                            <li><a href="../../index.php">HOME<span class="animation"></span></a></li>
                            <li><a href="#">QUEM SOMOS<span class="animation"></span></a></li>
                            <li><a href="../html/register.html">REGISTRE-SE<span class="animation"></span></a></li>
                            <li><a href="#">AGENDA<span class="animation"></span></a></li>
                            <li><a href="../html/nossaloja.php">LOJA<span class="animation"></span></a></li>
                            <li><a href="../../index.php#contact">CONTATO<span class="animation"></span></a></li>
                        </ul>
                    </nav>
                </div>
            </div>
            <h1>MEU CARRINHO</h1>
            <div class="container">
                <div class="cartoes">
                    <?php if (!empty($itensCarrinho)): ?>
                        <?php foreach ($itensCarrinho as $item): ?>
                            <div class="productCard">
                                <button class="closeButton"
                                    data-liv-id="<?php echo htmlspecialchars($item['liv_id'], ENT_QUOTES, 'UTF-8'); ?>">✖</button>

                                <table>
                                    <thead>
                                        <tr>
                                            <th class="product">Produto</th>
                                            <th>Título</th>
                                            <th>Qtdd</th>
                                            <th>Valor</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="generalTopProduct">
                                            <td class="imgProduct">
                                                <img src="<?php echo htmlspecialchars($item['liv_img']); ?>" alt="Livro">
                                            </td>
                                            <td class="descriptionProduct">
                                                <p>
                                                    <?php echo htmlspecialchars($item['liv_titulo'] . ' | ' . $item['aut_nome'] . ' | ' . $item['edi_nome']); ?>
                                                </p>
                                            </td>
                                            <td class="quantityProduct">
                                                <div class="quantityControl">
                                                    <button class="quantityButton"
                                                        data-carrinho-id="<?php echo htmlspecialchars($item['carrinho_id']); ?>">−</button>
                                                    <span
                                                        class="quantityValue"><?php echo htmlspecialchars($item['car_quantidade'] ?? 1); ?></span>
                                                    <button class="quantityButton"
                                                        data-carrinho-id="<?php echo htmlspecialchars($item['carrinho_id']); ?>">+</button>
                                                </div>


                                            </td>
                                            <td class="priceProduct">
                                                <span class="priceValue">R$
                                                    <?php echo number_format($item['liv_preco'], 2, ',', '.'); ?>
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="empty-cart-message">
                            <p>Carrinho vazio. Vamos às compras!</p>
                            <a href="nossaloja.php">Ir para loja</a>
                        </div>
                    <?php endif; ?>


                    <!-- Modal -->
                    <div id="modalErro" class="modal" style="display:none;">
                        <div class="modal-content">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-x-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                <path
                                    d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                            </svg>
                            <span class="close-btn" onclick="closeModal()">&times;</span>
                            <p>Código de cupom incorreto ou expirado.</p>
                        </div>
                    </div>

                    <!-- Modal de Sucesso -->
                    <div id="modalSucesso" class="modal" style="display:none;">
                        <div class="modal-content">
                            <span class="close-btn" onclick="closeModal()">
                                <i class="fas fa-times"></i>
                            </span>
                            <p>Cupom aplicado com sucesso!</p>
                        </div>
                    </div>



                    <script>
                        function mostrarModal() {
                            document.getElementById('modalErro').style.display = 'block';
                        }
                    </script>

                </div>
                <div class="infoProdutoFinal">
                    <h1>Resumo</h1>
                    <div class="subTotal">
                        <div class="subTotalDiv">Subtotal</div>
                        <div class="subTotalPrice">R$ <?php echo number_format($subtotal, 2, ',', '.'); ?></div>
                    </div>

                    <div class="prices">
                        <div class="total">Total</div>
                        <div class="priceProductFinal">R$ <?php echo number_format($subtotal, 2, ',', '.'); ?>
                        </div>
                    </div>
                    <div class="aVista">
                        <div class="vista">à vista</div>
                        <div class="priceAvista">R$ <?php echo number_format($subtotal, 2, ',', '.'); ?></div>
                    </div>

                    <a href="checkout.php"> <button class="button-57" role="button">
                            <span class="text">FINALIZAR PEDIDO</span>
                            <span><i class="fas fa-shopping-cart"></i></span>
                        </button></a>
                </div>
            </div>
            <div class="containerCupomFrete">
                <div class="cupom">
                    <h1>CUPOM DE DESCONTO</h1>
                    <div class="inputCupom">
                        <div class="inputWrapper">
                            <input type="text" name="cupom" id="cupom" placeholder=" ">
                            <label for="cupom">Cupom</label>
                        </div>
                        <button id="aplicarCupom">Aplicar</button>
                    </div>
                </div>
                <div class="frete">
                    <h1>Frete e Prazos</h1>
                    <div class="inputFrete">
                        <div class="inputWrapper">
                            <input type="text" name="cep" id="cep" placeholder=" " maxlength="9" required>
                            <label for="cep">Cep*</label>
                        </div>
                        <button>Calcular</button>
                    </div>
                    <div class="freteWrapper">
                        <p>Frete estimado: <span id="frete">R$ 0,00</span></p>
                    </div>
                </div>


            </div>
        </section>
    </main>
</body>

</html>