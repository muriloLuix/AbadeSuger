<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    echo "<div class='empty-cart-message'>
            <p>Usuário não logado. Por favor, faça login para acessar o carrinho.</p>
            <a href='login.php'>Fazer login</a>
          </div>";
    exit;
}

$cli_id = $_SESSION['user_id']; // ID do cliente logado
require '../php/info.php';

try {
    // Consulta para obter as informações do cliente
    $queryCliente = "
    SELECT 
        cli_nome,
        cli_sobrenome,
        cli_email,
        cli_telefone,
        cli_cep,
        cli_rua,
        cli_numero,
        cli_complemento,
        cli_bairro,
        cli_estado,
        cli_cpf
    FROM clientes
    WHERE cli_id = :cli_id
    ";

    $stmtCliente = $pdo->prepare($queryCliente);
    $stmtCliente->bindParam(':cli_id', $cli_id, PDO::PARAM_INT);
    $stmtCliente->execute();

    $dadosCliente = $stmtCliente->fetch(PDO::FETCH_ASSOC);

    if (!$dadosCliente) {
        echo "<div class='empty-cart-message'>
                <p>Informações do cliente não encontradas. Por favor, atualize seu cadastro.</p>
                <a href='editar_cliente.php'>Atualizar Cadastro</a>
              </div>";
        exit;
    }

    // Consulta para obter os itens do carrinho e informações dos livros
    $queryCarrinho = "
    SELECT 
        carrinho.car_id AS carrinho_id,
        carrinho.cli_id,
        carrinho.liv_id,
        carrinho.car_quantidade,
        livros.liv_titulo,
        livros.liv_preco,
        livros.liv_img,
        autor.aut_nome,
        editora.edi_nome
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

    // Calcula o subtotal dos itens no carrinho
    $subtotal = 0;
    if (!empty($itensCarrinho)) {
        foreach ($itensCarrinho as $item) {
            $livroPreco = floatval($item['liv_preco']);
            $quantidade = isset($item['car_quantidade']) ? intval($item['car_quantidade']) : 1; // Usa 1 como padrão
            $subtotal += $livroPreco * $quantidade;
        }
    }
} catch (PDOException $e) {
    echo "Erro ao buscar informações: " . $e->getMessage();
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
    <!-- Script -->
    <script src="../js/formaDePagamento.js" defer></script>
    <script src="../js/cepCheckout.js" defer></script>
    <script src="../js/checkoutEntrega.js" defer></script>
    <!-- Script -->
    <!-- css -->
    <link rel="stylesheet" href="../css/checkout.css">
    <!-- css -->
    <title>Abade Suger - Checkout</title>
</head>

<body>
    <h1>Finalizar Pedido</h1>
    <div class="tab_container">
        <input id="tab1" type="radio" name="tabs" checked>
        <label for="tab1"><span class="numberCircle">1</span><span>Carrinho</span></label>

        <input id="tab2" type="radio" name="tabs">
        <label for="tab2"><span class="numberCircle">2</span><span>Informações do Cliente</span></label>

        <input id="tab3" type="radio" name="tabs">
        <label for="tab3"><span class="numberCircle">3</span><span>Entrega</span></label>

        <input id="tab4" type="radio" name="tabs">
        <label for="tab4"><span class="numberCircle">4</span><span>Pagamento</span></label>

        <section id="content1" class="tab-content">
            <h3>Itens no Carrinho</h3>

            <?php if (!empty($itensCarrinho)): ?>
                <?php foreach ($itensCarrinho as $item): ?>
                    <div class="productCard">
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
                                            <span
                                                class="quantityValue"><?php echo htmlspecialchars($item['car_quantidade'] ?? 1); ?></span>
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

                <div class="subTotal">
                    <h4>Subtotal: R$ <?php echo number_format($subtotal, 2, ',', '.'); ?></h4>
                </div>
            <?php else: ?>
                <div class="empty-cart-message">
                    <p>Carrinho vazio. Vamos às compras!</p>
                    <a href="nossaloja.php">Ir para loja</a>
                </div>
            <?php endif; ?>
        </section>

        <section id="content2" class="tab-content">
            <h3>Informações do Cliente</h3>
            <?php if (!empty($dadosCliente)): ?>
                <ul class="customer-info">
                    <li>'<strong>Nome:</strong>
                        <?php echo htmlspecialchars($dadosCliente['cli_nome'] . ' ' . $dadosCliente['cli_sobrenome']); ?>
                    </li>
                    <li><strong>Email:</strong> <?php echo htmlspecialchars($dadosCliente['cli_email']); ?></li>
                    <li><strong>Telefone:</strong> <?php echo htmlspecialchars($dadosCliente['cli_telefone']); ?></li>
                    <li><strong>CPF:</strong> <?php echo htmlspecialchars($dadosCliente['cli_cpf']); ?></li>
                    <li><strong>Endereço:</strong>
                        <?php echo htmlspecialchars($dadosCliente['cli_rua'] . ', ' . $dadosCliente['cli_numero'] . ' ' . $dadosCliente['cli_complemento'] . ', ' . $dadosCliente['cli_bairro']); ?>
                    </li>
                    <li><strong>CEP:</strong> <?php echo htmlspecialchars($dadosCliente['cli_cep']); ?></li>
                    <li><strong>Estado:</strong> <?php echo htmlspecialchars($dadosCliente['cli_estado']); ?></li>
                </ul>
            <?php else: ?>
                <p>Informações do cliente não encontradas. Por favor, atualize seu cadastro.</p>
                <a href="editar_cliente.php">Atualizar Cadastro</a>
            <?php endif; ?>
        </section>


        <section id="content3" class="tab-content">
            <h3>Entrega</h3>
            <form id="formEntrega">
                <div class="form-group">
                    <label>
                        <input type="checkbox" id="semEntrega" name="semEntrega">
                        E-book (desabilita as opções de entrega)
                    </label>
                </div>
                <span class="ou">OU</span>
                <div id="entregaCampos">
                    <div class="form-group">
                        <label for="cep">CEP</label>
                        <input type="text" id="cep" name="ped_cep" placeholder="xxxxx-xxx" maxlength="9" required>
                    </div>
                    <div class="form-group">
                        <label for="rua">Rua</label>
                        <input type="text" id="rua" name="ped_rua" readonly required>
                    </div>
                    <div class="form-group">
                        <label for="numero">Número</label>
                        <input type="text" id="numero" name="ped_numero" required>
                    </div>
                    <div class="form-group">
                        <label for="complemento">Complemento</label>
                        <input type="text" id="complemento" name="ped_complemento">
                    </div>
                    <div class="form-group">
                        <label for="bairro">Bairro</label>
                        <input type="text" id="bairro" name="ped_bairro" readonly required>
                    </div>
                    <div class="form-group">
                        <label for="estado">Estado</label>
                        <input type="text" id="estado" name="ped_estado" readonly required>
                    </div>
                </div>
            </form>
        </section>

        <section id="content4" class="tab-content">
            <h4 class="payment-title">Escolha o método de pagamento</h4>
            <form action="../php/#" method="post">
                <div class="pymt-radio">
                    <div class="row-payment-method payment-row">
                        <div class="select-icon">
                            <input type="radio" id="radio1" name="radios" value="pp" disabled>
                            <label for="radio1"></label>
                        </div>
                        <div class="select-txt">
                            <p class="pymt-type-name">PayPal</p>
                            <p class="pymt-type-desc"><strong>(Não disponível)</strong> Pagamento seguro online. É
                                necessário cartão de crédito. Não é necessário ter conta no PayPal.</p>
                        </div>
                        <div class="select-logo">
                            <img src="https://www.dropbox.com/s/pycofx0gngss4ef/logo-paypal.png?raw=1" alt="PayPal" />
                        </div>
                    </div>
                </div>

                <div class="pymt-radio">
                    <div class="row-payment-method payment-row">
                        <div class="select-icon">
                            <input type="radio" id="radio2" name="radios" value="cc" disabled>
                            <label for="radio2"></label>
                        </div>
                        <div class="select-txt">
                            <p class="pymt-type-name">Cartão de Crédito</p>
                            <p class="pymt-type-desc"><strong>(Não disponível)</strong> Transferência segura usando sua
                                conta bancária. Pagamento online seguro. É necessário cartão de crédito. Visa, Maestro,
                                Discover, American Express.</p>
                        </div>
                        <div class="select-logo">
                            <div class="select-logo-sub logo-spacer">
                                <img src="https://www.dropbox.com/s/by52qpmkmcro92l/logo-visa.png?raw=1" alt="Visa" />
                            </div>
                            <div class="select-logo-sub">
                                <img src="https://www.dropbox.com/s/6f5dorw54xomw7p/logo-mastercard.png?raw=1"
                                    alt="MasterCard" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pymt-radio">
                    <div class="row-payment-method payment-row">
                        <div class="select-icon">
                            <input type="radio" id="radio3" name="radios" value="pix" checked>
                            <label for="radio3"></label>
                        </div>
                        <div class="select-txt">
                            <p class="pymt-type-name">Pix</p>
                            <p class="pymt-type-desc">Pague com Pix. Transferência instantânea, sem custos adicionais.
                                Escaneie o QR Code gerado para realizar o pagamento.</p>
                        </div>
                        <div class="select-logo logoPix">
                            <img src="../img/pixLogo.png" alt="Pix" />
                        </div>
                    </div>
                </div>

                <!-- Seção de informações do PayPal -->
                <div class="form-pp" id="formPayPal" style="display: none;">
                    <h4>Informações do PayPal</h4>
                    <div class="row-pp">
                        <label for="pp-email">E-mail do PayPal</label>
                        <input type="email" id="pp-email" name="pp-email" class="input">
                    </div>
                </div>

                <!-- Seção de informações do Cartão de Crédito -->
                <div class="form-cc" id="formCreditCard" style="display: none;">
                    <div class="row-cc">
                        <div class="cc-field">
                            <div class="cc-title">Número do Cartão</div>
                            <input type="text" class="input cc-txt text-validated" />
                        </div>
                    </div>
                    <div class="row-cc">
                        <div class="cc-field">
                            <div class="cc-title">Data de Validade</div>
                            <select class="input cc-ddl">
                                <option selected>01</option>
                                <option>02</option>
                                <option>03</option>
                                <option>04</option>
                            </select>
                            <select class="input cc-ddl">
                                <option>2023</option>
                                <option selected>2024</option>
                                <option>2025</option>
                            </select>
                        </div>
                        <div class="cc-field">
                            <div class="cc-title">Código CVV</div>
                            <input type="text" class="input cc-txt" />
                        </div>
                    </div>
                    <div class="row-cc">
                        <div class="cc-field">
                            <div class="cc-title">Nome no Cartão</div>
                            <input type="text" class="input cc-txt" />
                        </div>
                    </div>
                </div>

                <!-- Botões -->
                <div class="button-master-container">
                    <div class="button-container"><a href="#">Voltar para Entrega</a></div>
                    <div class="button-container button-finish">
                        <button type="button" id="finalizarPedido">Finalizar Pedido</button>
                    </div>

                    <script>
                        document.getElementById('finalizarPedido').addEventListener('click', function () {
                            const subtotal = <?php echo number_format($subtotal, 2, '.', ''); ?>;

                            fetch('../php/gerar-pix.php', {
                                method: 'POST',
                                headers: { 'Content-Type': 'application/json' },
                                body: JSON.stringify({ subtotal })
                            })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.redirect) {
                                        // Redirecionar para a página do QR Code
                                        window.location.href = data.redirect;
                                    } else if (data.erro) {
                                        alert('Erro ao gerar QR Code Pix: ' + data.erro);
                                    }
                                })
                                .catch(error => console.error('Erro na requisição:', error));
                        });

                    </script>


                </div>
            </form>
        </section>
    </div>
</body>

</html>