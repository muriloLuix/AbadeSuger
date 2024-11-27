<?php
include('../../assets/php/info.php'); // Conexão com o banco de dados

try {
    // Consulta para buscar as notícias
    $query = "SELECT * FROM noticias ORDER BY not_prioridade DESC, not_dtcriacao DESC";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $noticias = $stmt->fetchAll(PDO::FETCH_ASSOC); // Armazena as notícias em um array

    // Verifica se é uma requisição Ajax para retornar apenas as notícias prioritárias
    if (isset($_GET['ajax']) && $_GET['ajax'] === '1') {
        $noticiasPrioritarias = array_filter($noticias, function ($noticia) {
            return $noticia['not_prioridade'] == 1;
        });
        echo json_encode(array_values($noticiasPrioritarias));
        exit;
    }
} catch (PDOException $e) {
    echo "Erro ao buscar notícias: " . $e->getMessage();
    $noticias = [];
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
    <script src="../js/adicionar_agenda.js" defer></script>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Bootstrap -->
    <!-- Css -->
    <link rel="stylesheet" href="../css/agenda.css">
    <!-- Css -->
    <title> Abade Suger - Notícias</title>
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
                        <span>Notícias & Agenda</span>
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
            <div class="transparenteGeneral">
                <?php
                $noticiaPrincipal = null;

                // Identificar a notícia principal (not_prioridade = 1)
                foreach ($noticias as $noticia) {
                    if ($noticia['not_prioridade'] == 1) {
                        $noticiaPrincipal = $noticia;
                        break;
                    }
                }
                ?>

                <div class="transparentSectionNoticiasPrioridade">
                    <?php if ($noticiaPrincipal): ?>
                        <!-- Exibir a notícia principal -->
                        <div class="imagemNoticia">
                            <span class="highlightText">Não perca!</span>
                            <img src="<?php echo htmlspecialchars($noticiaPrincipal['not_img']); ?>"
                                alt="Imagem da Notícia">
                        </div>
                        <div class="contentSection">
                            <div class="logoAbadeGeneral">
                                <div class="logoAbade">
                                    <img src="../img/logoHeader.svg" alt="Logo Abade">
                                </div>
                                <div class="nomeAbade">Abade Suger</div>
                            </div>
                            <div class="tituloNoticia">
                                <?php echo htmlspecialchars($noticiaPrincipal['not_titulo']); ?>
                            </div>
                            <div class="btnNoticia">
                                <form id="formAdicionarAgenda" method="POST">
                                    <input type="hidden" name="not_id"
                                        value="<?php echo htmlspecialchars($noticiaPrincipal['not_id']); ?>">
                                    <input type="hidden" name="not_titulo"
                                        value="<?php echo htmlspecialchars($noticiaPrincipal['not_titulo']); ?>">
                                    <button type="button" class="agendaButton" id="adicionarAgendaBtn">Adicionar à sua
                                        Agenda</button>
                                </form>
                            </div>


                        </div>
                    <?php else: ?>
                        <!-- Exibir mensagem padrão -->
                        <div class="contentSection">
                            <div class="tituloNoticia">
                                Não há notícias principais no momento.
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Exibir as demais notícias (not_prioridade = 0) -->
                <?php foreach ($noticias as $noticia): ?>
                    <?php if ($noticia['not_prioridade'] == 0): ?>
                        <div class="transparentSectionNoticias novoCard">
                            <div class="imagemNoticia">
                                <img src="<?php echo htmlspecialchars($noticia['not_img']); ?>" alt="Imagem da Notícia">
                            </div>
                            <div class="contentSection">
                                <div class="logoAbadeGeneral">
                                    <div class="logoAbade">
                                        <img src="../img/logoHeader.svg" alt="Logo Abade">
                                    </div>
                                    <div class="nomeAbade">Abade Suger</div>
                                </div>
                                <div class="tituloNoticia">
                                    <?php echo htmlspecialchars($noticia['not_titulo']); ?>
                                </div>
                                <div class="descricaoNoticia">
                                    <?php echo htmlspecialchars($noticia['not_resumo']); ?>
                                </div>
                                <div class="infoNoticia">
                                    <div>
                                        <span><?php echo htmlspecialchars($noticia['not_dtcriacao']); ?></span>
                                    </div>
                                    <div>
                                        <a href="noticiaCompleta.php?id=<?php echo urlencode($noticia['not_id']); ?>"
                                            class="verMaisButton">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                                class="bi bi-newspaper" viewBox="0 0 16 16">
                                                <path
                                                    d="M0 2.5A1.5 1.5 0 0 1 1.5 1h11A1.5 1.5 0 0 1 14 2.5v10.528c0 .3-.05.654-.238.972h.738a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 1-1 0v9a1.5 1.5 0 0 1-1.5 1.5H1.497A1.497 1.497 0 0 1 0 13.5zM12 14c.37 0 .654-.211.853-.441.092-.106.147-.279.147-.531V2.5a.5.5 0 0 0-.5-.5h-11a.5.5 0 0 0-.5.5v11c0 .278.223.5.497.5z" />
                                                <path
                                                    d="M2 3h10v2H2zm0 3h4v3H2zm0 4h4v1H2zm0 2h4v1H2zm5-6h2v1H7zm3 0h2v1h-2zM7 8h2v1H7zm3 0h2v1h-2zm-3 2h2v1H7zm3 0h2v1h-2zm-3 2h2v1H7zm3 0h2v1h-2z" />
                                            </svg>
                                            Ver matéria completa
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>

            </div>

            <div class="transparenteGeneral2">
                <?php
                // Buscar os itens da agenda
                try {
                    $query = "SELECT not_titulo FROM AGENDA";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute();
                    $agendaItens = $stmt->fetchAll(PDO::FETCH_ASSOC);
                } catch (PDOException $e) {
                    echo 'Erro ao buscar itens da agenda: ' . $e->getMessage();
                    $agendaItens = [];
                }
                ?>

                <div class="transparentSectionNoticias novoCard2">
                    <h1>SUA AGENDA</h1>
                    <div class="itensAgenda">
                        <?php if (!empty($agendaItens)): ?>
                            <?php foreach ($agendaItens as $item): ?>
                                <div class="itemAgenda">
                                    <div class="circle"></div>
                                    <div class="evento"><?php echo htmlspecialchars($item['not_titulo']); ?></div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="itemAgenda">
                                <div class="circle"></div>
                                <div class="evento">Nenhum evento na sua agenda ainda.</div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </section>
</body>

</html>