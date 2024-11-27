<?php

include('../assets/php/info.php');

$query = "SELECT liv_titulo FROM livros";
$stmt = $pdo->prepare($query);
$stmt->execute();

$livros = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Script -->
    <script src="../assets/js/menu.js" defer></script>
    <!-- Script -->
    <!-- css -->
    <link rel="stylesheet" href="../assets/css/contato.css">
    <!-- css -->
    <!-- Favicon -->
    <link rel="shortcut icon" href="../assets/img/favicon.png" type="image/x-icon" />
    <!-- Favicon -->
    <title> Abade Suger - Contato</title>
</head>

<body>
    <div class="orange">
        <img src="../assets/img/logoMenu.svg" alt="Logo Menu" id="dropdown-btn">
    </div>
    <div class="dropdown" id="dropdown-menu">
        <button class="close-btn" id="close-menu">&times;</button>
        <div class="inspiracoes">
            <span>Inspirações</span>
            <a href="../assets/html/nossasinspiracoes.html" class="dropdown-item"><img src="../assets/img/arvoreSvg.svg"
                    alt="Nossas Inspirações"></a>
        </div>
        <hr class="lineMenu">
        <div class="lojaMenu">
            <span>Loja</span>
            <a href="../assets/html/nossaloja.php" class="dropdown-item"><img src="../assets/img/shopping-bag.svg"
                    alt="Nossa loja"></a>
        </div>
        <hr class="lineMenu">
        <div class="agendaMenu">
            <span>Agenda</span>
            <a href="../assets/html/noticias.php" class="dropdown-item"><img src="../assets/img/calendar.svg"
                    alt="Agenda e Notícias"></a>
        </div>
        <hr class="lineMenu">
        <div class="publiqueObraMenu">
            <span>Publique sua<br>Obra</span>
            <a href="../assets/html/publiquesuaobra.html" class="dropdown-item"><img src="../assets/img/lamp.svg"
                    alt="Publicar uma obra"></a>
        </div>
        <hr class="lineMenu">
        <div class="indiqueUmaObraMenu">
            <span>Indique uma<br> Obra</span>
            <a href="../assets/html/indiqueumaobra.html" class="dropdown-item"><img src="../assets/img/lupa.svg"
                    alt="Indique uma obra"></a>
        </div>
        <hr class="lineMenu">
        <div class="contaMenu">
            <span>Conta</span>
            <a href="../assets/html/contacli.php" class="dropdown-item"><img src="../assets/img/user.svg"
                    alt="Conta"></a>
        </div>
    </div>
    <footer id="contact">
        <div class="generalFooter">
            <aside class="logoFooter">
                <img src="../assets/img/logoFooter.png" alt="Logo Abade" />
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
                <img src="../assets/img/escadaDeLivro.svg" alt="Escada de" />
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
                        <li><a href="../index.php">Home</a></li>
                        <li><a href="#">Quem somos</a></li>
                        <li><a href="../assets/html/register.html">Registre-se</a></li>
                        <li><a href="../assets/html/noticias.php">Agenda</a></li>
                        <li><a href="../assets/html/nossaloja.php">Loja</a></li>
                        <li><a href="../index.php#contato">Contato</a></li>
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
                        <?php if (!empty($livros)): ?>
                            <?php foreach ($livros as $livro): ?>
                                <li>
                                    <?php echo htmlspecialchars($livro['liv_titulo']); ?>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li>Nenhum livro cadastrado</li>
                        <?php endif; ?>
                    </ul>
                </div>

            </aside>
            <div class="credits">
                <p>Todos os direitos reservados para <a href="https://echocodes.web.app/" target="_blank">@echo</a> 2024
                </p>
            </div>
        </div>
        <div class="logos">
            <div class="logo1">
                <a href="https://www.goecho.com.br/" target="_blank"><img src="../assets/img/ECHO.png"
                        alt="Logo Echo" /></a>
            </div>
            <div class="logo2">
                <img src="../assets/img/LOGO.png" alt="Logo Abade" />
            </div>
        </div>


    </footer>
</body>

</html>