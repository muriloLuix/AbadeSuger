<?php
require '../php/info.php';

// Verifica se o parâmetro 'id' foi passado na URL e o armazena em $livro_id
$livro_id = isset($_GET['id']) ? $_GET['id'] : null;

if ($livro_id) {

    $query = "SELECT * FROM LIVROS WHERE liv_id = :livro_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':livro_id', $livro_id, PDO::PARAM_INT);
    $stmt->execute();

    $livro = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($livro) {
        // Busca o nome do autor no bd
        $autor_id = $livro['aut_id'];
        $query_autor = "SELECT aut_nome FROM autor WHERE aut_id = :autor_id";
        $stmt_autor = $pdo->prepare($query_autor);
        $stmt_autor->bindParam(':autor_id', $autor_id, PDO::PARAM_INT);
        $stmt_autor->execute();
        $autor = $stmt_autor->fetch(PDO::FETCH_ASSOC);

        // Busca o nome da editora no bd
        $editora_id = $livro['edi_id'];
        $query_editora = "SELECT edi_nome FROM EDITORA WHERE edi_id = :editora_id";
        $stmt_editora = $pdo->prepare($query_editora);
        $stmt_editora->bindParam(':editora_id', $editora_id, PDO::PARAM_INT);
        $stmt_editora->execute();
        $editora = $stmt_editora->fetch(PDO::FETCH_ASSOC);

        // Busca o nome do idioma no bd
        $idioma_id = $livro['liv_idioma'];
        $query_idioma = "SELECT idi_nome FROM IDIOMA WHERE idi_id = :idioma_id";
        $stmt_idioma = $pdo->prepare($query_idioma);
        $stmt_idioma->bindParam(':idioma_id', $idioma_id, PDO::PARAM_INT);
        $stmt_idioma->execute();
        $idioma = $stmt_idioma->fetch(PDO::FETCH_ASSOC);

        $categoria_id = $livro['cat_id'];
        $query_categoria = "SELECT cat_nome FROM categoria WHERE cat_id = :categoria_id";
        $stmt_categoria = $pdo->prepare($query_categoria);
        $stmt_categoria->bindParam(':categoria_id', $categoria_id, PDO::PARAM_INT);
        $stmt_categoria->execute();
        $categoria = $stmt_categoria->fetch(PDO::FETCH_ASSOC);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Favicon -->
    <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon" />
    <!-- Favicon -->
    <!-- script -->
    <script src="../js/descriptionProduct.js" defer></script>
    <script src="../js/correios.js" defer></script>
    <!-- script -->
    <!-- Css -->
    <link rel="stylesheet" href="../css/descriptionProduct.css">
    <!-- Css -->
    <title> Abade Suger - <?php echo htmlspecialchars($livro['liv_titulo']); ?></title>
</head>

<body>
    <div class="generalHeader">
        <div class="logo" id="logo">
            <img src="../../assets/img/logoHeader.svg" alt="Logo Abade">
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
                    <li><a href="../../assets/html/register.html">REGISTRE-SE<span class="animation"></span></a></li>
                    <li><a href="#">AGENDA<span class="animation"></span></a></li>
                    <li><a href="../../assets/html/nossaloja.php">LOJA<span class="animation"></span></a></li>
                    <li><a href="../../index.php#contact">CONTATO<span class="animation"></span></a></li>
                </ul>
            </nav>
        </div>
    </div>
    <div class="container">
        <section class="product-item">
            <div class="produto">
                <div class="product-gallery">
                    <img class="product-galleryBig"
                        src="../img/capalivro/<?php echo htmlspecialchars(basename(str_replace('../../assets/', '', $livro['liv_img']))); ?>"
                        alt="" id="slider">
                </div>
                <div class="product-gallery-thumbnails">
                    <img src="../img/capalivro/<?php echo htmlspecialchars(basename(str_replace('../../assets/', '', $livro['liv_img']))); ?>"
                        alt="" class="thumbnail"
                        data-target="../img/capalivro/<?php echo htmlspecialchars(basename(str_replace('../../assets/', '', $livro['liv_img']))); ?>">
                </div>

                <div class="product-data">
                    <h2 class="product-name"><?php echo htmlspecialchars($livro['liv_titulo']); ?></h2>
                    <p class="product-price"><?php echo htmlspecialchars($livro['liv_preco']); ?></p>
                    <p class="product-autor">
                        <?php
                        echo htmlspecialchars($autor['aut_nome']) . ' | '
                            . htmlspecialchars($livro['liv_titulo']) . ' | '
                            . htmlspecialchars($editora['edi_nome']) . ' | '
                            . htmlspecialchars($idioma['idi_nome']) .
                            ' | '
                            . htmlspecialchars($categoria['cat_nome']);
                        ?>
                    </p>
                    <p class="product-autor">Estoque:
                        <?php echo htmlspecialchars($livro['liv_estoque'] . ' Livro(s)') ?>
                    </p>
                    <p class="product-autor">Páginas: <?php echo htmlspecialchars($livro['liv_pag']) ?></p>


                    <button class="buy-btn">Adicionar ao carrinho</button>

                    <div class="frete-section">
                        <label for="cep">Digite seu CEP para calcular o frete:</label>
                        <input type="text" id="cep" name="cep" placeholder="CEP" maxlength="10"
                            oninput="formatarCep(this)">
                        <button id="calcularFreteBtn">Calcular Frete</button>
                        <p id="freteResultado"></p>
                    </div>
                </div>

            </div>

            <section class="product-details">
                <div class="tabs">
                    <button class="tab-button active" data-target="description">Descrição</button>
                    <button class="tab-button" data-target="additional-info">Informação Adicional</button>
                    <button class="tab-button" data-target="reviews">Avaliações</button>
                </div>
                <div class="tab-content">
                    <div class="tab-panel active" id="description">
                        <h1>Descrição</h1>
                        <p><?php echo $livro['liv_desc']; ?></p>
                    </div>

                    <div class="tab-panel" id="additional-info">
                        <h1>Informações Adicionais</h1>
                        <p><?php echo $livro['liv_adicional']; ?></p>
                    </div>
                    <div class="tab-panel" id="reviews">
                        <h1>Avaliações</h1>
                        <p>Avaliações</p>
                    </div>
                </div>
            </section>
        </section>
    </div>
    <footer id="contact">
        <div class="generalFooter">
            <aside class="logoFooter">
                <img src="../../assets/img/logoFooter.png" alt="Logo Abade" />
            </aside>
            <aside class="contact">
                <h1>Entrar em contato</h1>
                <form class="form" action="" method="post">
                    <div class="form-group">
                        <label for="name">Nome</label>
                        <input type="text" name="name" id="name" required />
                    </div>
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" name="email" id="email" required />
                    </div>
                    <div class="form-group">
                        <label for="option">Como podemos ajudar?</label>
                        <select name="option" id="option" required>
                            <option value="" selected disabled></option>
                            <option value="1">teste</option>
                            <option value="2"></option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="msg">Mensagem</label>
                        <textarea name="mesg" id="msg" required></textarea>
                    </div>
                    <div class="form-group form-group-button">
                        <button class="submit" type="submit">Enviar</button>
                    </div>
                </form>
            </aside>
            <aside class="books">
                <img src="../../assets/img/escadaDeLivro.svg" alt="Escada de" />
            </aside>
        </div>
        <div class="purpleFooter">
            <aside class="logoFooter2">

            </aside>
            <aside class="contentFooter">
                <div class="footer-column">
                    <h3>Suporte</h3>
                    <ul>
                        <li><a href="#">Reclame aqui</a></li>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Socorro</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Mapa do site</h3>
                    <ul>
                        <li><a href="#">Home</a></li>
                        <li><a href="#">Quem somos</a></li>
                        <li><a href="assets/html/register.html">Registre-se</a></li>
                        <li><a href="#">Agenda</a></li>
                        <li><a href="#">Loja</a></li>
                        <li><a href="#">Contato</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Parceiros</h3>
                    <ul>
                        <li><a href="#">IBSEC</a></li>
                        <li><a href="#">IF</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Livros Físicos <span>↓</span></h3>
                    <ul>
                        <li>XXXXXX XX XXXXX</li>
                        <li>XXXXXX XX XXXXX</li>
                        <li>XXXXXX XX XXXXX</li>
                        <li>XXXXXX XX XXXXX</li>
                        <li>XXXXXX XX XXXXX</li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Artigos <span>↓</span></h3>
                    <ul>
                        <li>YYY YY YYY</li>
                        <li>YYY YY YYY</li>
                        <li>YYY YY YYY</li>
                        <li>YYY YY YYY</li>
                        <li>YYY YY YYY</li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>E-books <span>↓</span></h3>
                    <ul>
                        <li>ZZ ZZ ZZZ ZZ</li>
                        <li>ZZ ZZ ZZZ ZZ</li>
                        <li>ZZ ZZ ZZZ ZZ</li>
                        <li>ZZ ZZ ZZZ ZZ</li>
                        <li>ZZ ZZ ZZZ ZZ</li>
                    </ul>
                </div>
            </aside>
            <div class="credits">
                <p>Todos os direitos reservados para <a href="www.goecho.com.br" target="_blank">@echo</a> 2024
                </p>
            </div>
        </div>
        <div class="logos">
            <div class="logo1">
                <a href="https://www.goecho.com.br/" target="_blank"><img src="../../assets/img/ECHO.png"
                        alt="Logo Echo" /></a>
            </div>
            <div class="logo2">
                <img src="../../assets/img/LOGO.png" alt="Logo Abade" />
            </div>
        </div>


    </footer>
</body>


</html>