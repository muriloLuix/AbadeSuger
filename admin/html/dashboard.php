<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['adm_id'])) {
    header("Location: ../admin.php"); // Redireciona para a página de login
    exit();
}
?>

<!-- O restante do conteúdo do dashboard vai aqui -->


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Favicon -->
    <link rel="shortcut icon" href="../../assets/img/favicon.png" type="image/x-icon">
    <!-- Favicon -->
    <!-- Script -->
    <script src="../js/modalLivro.js" defer></script>
    <script src="../js/menu.js" defer></script>
    <script src="../js/modalCupom.js" defer></script>
    <script src="../js/modalEditora.js" defer></script>
    <script src="../js/modalEdicaoCupom.js" defer></script>
    <script src="../js/excluirCupom.js" defer></script>
    <script src="../js/modalAutores.js" defer></script>
    <script src="../js/modalCategoria.js" defer></script>
    <script src="../js/excluirCategoria.js" defer></script>
    <script src="../js/excluirEditora.js" defer></script>
    <script src="../js/editarLivro.js" defer></script>
    <script src="../js/modalNoticias.js" defer></script>
    <script src="../js/editarNoticias.js" defer></script>
    <script src="../js/excluirNoticia.js" defer></script>
    <!-- Script -->
    <!-- Css -->
    <link rel="stylesheet" href="../css/dashboard.css">
    <!-- Css -->
    <title> Admin - Dashboard</title>

</head>

<body>
    <div class="admin-panel clearfix">
        <div class="slidebar">
            <div class="logo">
                <img src="../../assets/img/LOGO.png" alt="">
            </div>
            <ul>
                <li><a href="#perfil" id="targeted">Perfil</a></li>
                <li><a href="#livros">Livros</a></li>
                <li><a href="#autores">Autores</a></li>
                <li><a href="#categoria">Categoria</a></li>
                <li><a href="#cupom">Cupom</a></li>
                <li><a href="#editora">Editora</a></li>
                <li><a href="#noticias">Noticias</a></li>
                <!-- <li><a href="#widgets">widgets</a></li>
                <li><a href="#tools">tools</a></li>
                <li><a href="#settings">settings</a></li> -->
                <form action="../php/logout.php" method="POST" onsubmit="return confirmLogout()">
                    <button type="submit" class="logoutBtn">Logout</button>
                </form>
                <script>
                    function confirmLogout() {

                        return confirm("Tem certeza que deseja sair do sistema?");
                    }
                </script>


            </ul>
        </div>
        <div class="main">
            <ul class="topbar clearfix">
                <li><a href="#">q</a></li>
                <li><a href="#">p</a></li>
                <li><a href="#">o</a></li>
                <li><a href="#">f</a></li>
                <li><a href="#">n</a></li>
            </ul>
            <div class="mainContent clearfix">
                <div id="perfil" class="hidden">
                    <h2 class="header"><span class="icon"></span>Perfil</h2>
                    <?php

                    require '../../assets/php/info.php';

                    // Recupera os dados da sessão
                    $admin_nome = $_SESSION['adm_nome'] ?? 'Nome não disponível';
                    $admin_email = $_SESSION['adm_email'] ?? 'Email não disponível';
                    ?>
                    <div class="perfil-container">
                        <p><strong>Nome:</strong> <?= htmlspecialchars($admin_nome); ?></p>
                        <p><strong>Email:</strong> <?= htmlspecialchars($admin_email); ?></p>
                    </div>
                </div>

                <div id="livros" class="hidden">
                    <h2 class="header">Cadastro de Livros</h2>

                    <!-- Botão para abrir o modal -->
                    <button id="openModalButton" class="btn-cadastrar-livro" style="margin-top: 20px;">Cadastrar
                        Livro</button>

                    <!-- Modal -->
                    <div id="cadastrarLivroModal" class="modal">
                        <div class="modal-content">
                            <span class="close-button">&times;</span>
                            <h3>Cadastrar Novo Livro</h3>
                            <form id="formLivro" method="POST" action="../php/cadastrar_livro.php"
                                enctype="multipart/form-data">
                                <!-- Campos do formulário -->
                                <?php
                                // Conexão com o banco de dados
                                include('../../assets/php/info.php');

                                try {
                                    // Consulta para buscar autores
                                    $query = "SELECT aut_id, aut_nome FROM autor ORDER BY aut_nome ASC";
                                    $stmt = $pdo->prepare($query);
                                    $stmt->execute();
                                    $autores = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                } catch (PDOException $e) {
                                    echo "Erro ao buscar autores: " . $e->getMessage();
                                }
                                ?>

                                <label for="aut_id">Autor:</label>
                                <select id="aut_id" name="aut_id" required>
                                    <option value="">Selecione o autor</option>
                                    <?php foreach ($autores as $autor): ?>
                                        <option value="<?php echo htmlspecialchars($autor['aut_id']); ?>">
                                            <?php echo htmlspecialchars($autor['aut_nome']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>

                                <?php
                                try {
                                    // Consulta para buscar editoras
                                    $queryEditora = "SELECT edi_id, edi_nome FROM editora ORDER BY edi_nome ASC";
                                    $stmtEditora = $pdo->prepare($queryEditora);
                                    $stmtEditora->execute();
                                    $editoras = $stmtEditora->fetchAll(PDO::FETCH_ASSOC);
                                } catch (PDOException $e) {
                                    echo "Erro ao buscar editoras: " . $e->getMessage();
                                }
                                ?>

                                <label for="edi_id">Editora:</label>
                                <select id="edi_id" name="edi_id" required>
                                    <option value="">Selecione a editora</option>
                                    <?php foreach ($editoras as $editora): ?>
                                        <option value="<?php echo htmlspecialchars($editora['edi_id']); ?>">
                                            <?php echo htmlspecialchars($editora['edi_nome']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>

                                <?php
                                try {
                                    // Consulta para buscar categorias
                                    $queryCategoria = "SELECT cat_id, cat_nome FROM categoria ORDER BY cat_nome ASC";
                                    $stmtCategoria = $pdo->prepare($queryCategoria);
                                    $stmtCategoria->execute();
                                    $categorias = $stmtCategoria->fetchAll(PDO::FETCH_ASSOC);
                                } catch (PDOException $e) {
                                    echo "Erro ao buscar categorias: " . $e->getMessage();
                                }
                                ?>

                                <label for="cat_id">Categoria:</label>
                                <select id="cat_id" name="cat_id" required>
                                    <option value="">Selecione a categoria</option>
                                    <?php foreach ($categorias as $categoria): ?>
                                        <option value="<?php echo htmlspecialchars($categoria['cat_id']); ?>">
                                            <?php echo htmlspecialchars($categoria['cat_nome']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>

                                <?php
                                try {
                                    // Consulta para buscar atividades
                                    $queryAtividade = "SELECT atv_id, atv_desc FROM status ORDER BY atv_desc ASC";
                                    $stmtAtividade = $pdo->prepare($queryAtividade);
                                    $stmtAtividade->execute();
                                    $atividades = $stmtAtividade->fetchAll(PDO::FETCH_ASSOC); // Armazena as atividades em um array
                                } catch (PDOException $e) {
                                    echo "Erro ao buscar atividades: " . $e->getMessage();
                                }
                                ?>


                                <label for="atv_id">Atividade:</label>
                                <select id="atv_id" name="atv_id" required>
                                    <option value="">Selecione a atividade</option>
                                    <?php foreach ($atividades as $atividade): ?>
                                        <option value="<?php echo htmlspecialchars($atividade['atv_id']); ?>">
                                            <?php echo htmlspecialchars($atividade['atv_desc']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>

                                <?php
                                try {
                                    // Consulta para buscar idiomas
                                    $queryIdioma = "SELECT idi_id, idi_nome FROM idioma ORDER BY idi_nome ASC";
                                    $stmtIdioma = $pdo->prepare($queryIdioma);
                                    $stmtIdioma->execute();
                                    $idiomas = $stmtIdioma->fetchAll(PDO::FETCH_ASSOC); // Armazena os idiomas em um array
                                } catch (PDOException $e) {
                                    echo "Erro ao buscar idiomas: " . $e->getMessage();
                                }
                                ?>

                                <label for="liv_idioma">Idioma:</label>
                                <select id="liv_idioma" name="liv_idioma" required>
                                    <option value="">Selecione o idioma</option>
                                    <?php foreach ($idiomas as $idioma): ?>
                                        <option value="<?php echo htmlspecialchars($idioma['idi_id']); ?>">
                                            <?php echo htmlspecialchars($idioma['idi_nome']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>

                                <label for="titulo">Título:</label>
                                <input type="text" id="titulo" name="liv_titulo" required>

                                <label for="dtpublicacao">Data de Publicação:</label>
                                <input type="date" id="dtpublicacao" name="liv_dtpublicacao" required>

                                <label for="preco">Preço:</label>
                                <input type="text" id="preco" name="liv_preco" required>

                                <label for="estoque">Estoque:</label>
                                <input type="number" id="estoque" name="liv_estoque" required>

                                <label for="desc">Descrição:</label>
                                <textarea id="desc" name="liv_desc" rows="4" required></textarea>

                                <label for="adc">Informações Adicionais:</label>
                                <textarea id="adc" name="liv_adicional" rows="4" required></textarea>

                                <label for="pag">Número de Páginas:</label>
                                <input type="number" id="pag" name="liv_pag" required>

                                <label for="imagem">Imagem do Livro:</label>
                                <input type="file" id="imagem" name="liv_img" accept="image/*" required>

                                <button type="submit">Cadastrar</button>
                            </form>
                        </div>
                    </div>
                    <script>
                        // Função para formatar o preço conforme a lógica de divisão por 100
                        function formatarPreco(event) {
                            let preco = event.target.value;

                            // Remove qualquer caractere que não seja número
                            preco = preco.replace(/[^0-9]/g, '');

                            // Se o valor estiver vazio, não faz nada
                            if (preco === '') {
                                event.target.value = '';
                                return;
                            }

                            // Converte o valor para número
                            let precoNumerico = parseInt(preco);

                            // Divide o valor por 100 para ajustar o preço (por exemplo, 100 vira 1,00)
                            precoNumerico = precoNumerico / 100;

                            // Formata o número com vírgula e 2 casas decimais
                            preco = precoNumerico.toFixed(2).replace('.', ',');

                            // Atualiza o valor do campo
                            event.target.value = preco;
                        }

                        // Função para tratar o envio do formulário e substituir a vírgula por ponto
                        document.getElementById('formLivro').addEventListener('submit', function (e) {
                            let precoInput = document.getElementById('preco');

                            // Substitui a vírgula por ponto antes de enviar ao servidor
                            precoInput.value = precoInput.value.replace(',', '.');
                        });

                        // Adiciona o evento de input no campo de preço
                        document.getElementById('preco').addEventListener('input', formatarPreco);
                    </script>

                    <script>
                        // Função para tratar o envio do formulário via AJAX
                        document.getElementById('formLivro').addEventListener('submit', function (e) {
                            e.preventDefault(); // Impede o envio tradicional do formulário

                            let formData = new FormData(this); // Captura os dados do formulário

                            // Envia os dados via AJAX
                            fetch('../php/cadastrar_livro.php', {
                                method: 'POST',
                                body: formData
                            })
                                .then(response => response.text()) // Recebe a resposta do PHP
                                .then(data => {
                                    // Exibe o alerta de acordo com a resposta do servidor
                                    alert(data); // Exibe a mensagem de sucesso ou erro
                                    if (data === "Livro cadastrado com sucesso!") {
                                        // Limpa o formulário após o cadastro bem-sucedido
                                        document.getElementById('formLivro').reset();
                                    }
                                })
                                .catch(error => {
                                    console.error('Erro ao cadastrar o livro:', error);
                                    alert('Erro ao cadastrar o livro. Tente novamente.');
                                });
                        });
                    </script>

                    <!-- Tabela de livros cadastrados -->
                    <h3>Livros Cadastrados</h3>
                    <table id="tabelaLivros">
                        <thead>
                            <tr>
                                <th>Título</th>
                                <th>Preço</th>
                                <th>Estoque</th>
                                <th>Status</th>
                                <th>Ações</th> <!-- Coluna para os botões de ação -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Exemplo de consulta para buscar livros no banco
                            include('../../assets/php/info.php');
                            $query = "SELECT liv_id, liv_titulo, liv_preco, liv_estoque, atv_id FROM livros";
                            try {
                                $stmt = $pdo->prepare($query);
                                $stmt->execute();
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['liv_titulo']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['liv_preco']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['liv_estoque']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['atv_id']) . "</td>";
                                    // Botão de editar
                                    echo "<td><button class='btn-editar-livro' data-id='" . $row['liv_id'] . "' onclick='editarLivro(" . json_encode($row) . ")'>Editar</button>";
                                    echo "<button class='btn-excluir-livro' data-id='" . $row['liv_id'] . "'>Excluir</button>
                                    </td>";
                                    ;

                                    echo "</tr>";
                                }
                            } catch (PDOException $e) {
                                echo "Erro na consulta: " . $e->getMessage();
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <div id="editarLivroModal" class="modal">
                    <div class="modal-content">
                        <span class="close-button" onclick="fecharModal()">×</span>
                        <h3>Editar Livro</h3>
                        <form id="formEditarLivro" method="POST" action="../php/editar_livro.php">
                            <input type="hidden" id="edit_liv_id" name="liv_id">
                            <label for="cat_id">Categoria:</label>
                            <select id="cat_id" name="cat_id" required>
                                <option value="">Selecione a categoria</option>
                            </select>
                            <label for="edit_atv_id">Atividade:</label>
                            <select id="edit_atv_id" name="atv_id" required>
                                <option value="">Selecione a atividade</option>
                            </select>
                            <label for="edit_titulo">Título:</label>
                            <input type="text" id="edit_titulo" name="liv_titulo" required>
                            <label for="edit_preco">Preço:</label>
                            <input type="text" id="edit_preco" name="liv_preco" required>
                            <label for="edit_estoque">Estoque:</label>
                            <input type="number" id="edit_estoque" name="liv_estoque" required>
                            <label for="edit_desc">Descrição:</label>
                            <textarea id="edit_desc" name="liv_desc" rows="4" required></textarea>
                            <label for="edit_adc">Informações Adicionais:</label>
                            <textarea id="edit_adc" name="liv_adicional" rows="4" required></textarea>
                            <label for="edit_pag">Número de Páginas:</label>
                            <input type="number" id="edit_pag" name="liv_pag" required>
                            <button type="submit">Salvar Alterações</button>
                        </form>

                    </div>
                </div>
                <div id="mensagemModal" class="modal">
                    <div class="modal-content">
                        <span class="close-button" onclick="fecharMensagemModal()">×</span>
                        <p id="mensagemTexto"></p>
                    </div>
                </div>

                <!-- Modal de Confirmação para Exclusão de Livro -->
                <div id="modalExcluirLivro" class="modal">
                    <div class="modal-content">
                        <span class="close-button" id="closeExcluirLivro">&times;</span>
                        <h2>Excluir Livro</h2>
                        <p>Tem certeza de que deseja excluir este livro?</p>
                        <form id="formExcluirLivro" method="POST">
                            <input type="hidden" id="delete_liv_id" name="liv_id">
                            <button type="submit" class="btn-excluir-edicao-noticia">Excluir</button>
                            <button type="button" id="cancelExcluirLivro"
                                class="cancelExcluirNoticias">Cancelar</button>
                        </form>
                    </div>
                </div>


                <script>
                    // Função para mostrar o formulário de cadastro de livro
                    function mostrarFormularioCadastrar() {
                        var form = document.getElementById("formCadastrarLivro");
                        if (form.style.display === "none") {
                            form.style.display = "block";
                        } else {
                            form.style.display = "none";
                        }
                    }
                </script>

                <div id="autores" class="hidden">
                    <h2 class="header">Cadastro de Autores</h2>

                    <!-- Formulário de Cadastro de Autor -->
                    <form action="../php/cadastrar_autor.php" method="POST" class="formAutor">
                        <label for="aut_nome">Nome do Autor:</label>
                        <input type="text" id="aut_nome" name="aut_nome" required>

                        <button type="submit">Cadastrar Autor</button>
                    </form>
                    <script>
                        document.addEventListener("DOMContentLoaded", function () {
                            const formAutor = document.querySelector('.formAutor'); // Formulário de cadastro de autor
                            const tabelaAutores = document.querySelector('#tabelaAutores tbody'); // Tabela de autores

                            formAutor.addEventListener('submit', function (e) {
                                e.preventDefault(); // Impede o envio tradicional do formulário

                                const formData = new FormData(formAutor);
                                const xhr = new XMLHttpRequest();
                                xhr.open('POST', formAutor.action, true); // Envia para cadastrar_autor.php

                                xhr.onload = function () {
                                    if (xhr.status === 200) {
                                        const response = JSON.parse(xhr.responseText);
                                        if (response.success) {
                                            // Exibe a mensagem de sucesso
                                            alert('Autor cadastrado com sucesso!');

                                            // Adiciona o autor à tabela sem recarregar a página
                                            const novaLinha = document.createElement('tr');
                                            novaLinha.innerHTML = `
                        <td>${response.nome}</td>
                        <td>
                            <button class='btn-editar-autor' data-id=''>Editar</button>
                            <button class='btn-excluir-autor' data-id=''>Excluir</button>
                        </td>
                    `;
                                            tabelaAutores.appendChild(novaLinha);
                                        } else {
                                            alert(response.message || 'Erro ao cadastrar o autor.');
                                        }
                                    } else {
                                        alert('Erro ao se comunicar com o servidor.');
                                    }
                                };

                                xhr.send(formData); // Envia os dados do formulário
                            });
                        });

                    </script>
                    <h3>Autores Cadastrados</h3>
                    <table id="tabelaAutores">
                        <thead>
                            <tr>
                                <th>Nome do Autor</th>
                                <th>Ações</th> <!-- Coluna para os botões de ação -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include('../../assets/php/info.php'); // Certifique-se de que o caminho está correto
                            
                            // Consulta para selecionar todos os autores
                            $query = "SELECT aut_nome, aut_id FROM autor";

                            try {
                                // Preparar e executar a consulta
                                $stmt = $pdo->prepare($query);
                                $stmt->execute();

                                // Exibir os resultados
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<tr id='autor_" . $row['aut_id'] . "'>";
                                    echo "<td>" . htmlspecialchars($row['aut_nome']) . "</td>";
                                    echo "<td>
                            <button class='btn-editar-autor' data-id='" . $row['aut_id'] . "'>Editar</button>
                            <button class='btn-excluir-autor' data-id='" . $row['aut_id'] . "'>Excluir</button>
                          </td>";
                                    echo "</tr>";
                                }

                            } catch (PDOException $e) {
                                echo "Erro na consulta: " . $e->getMessage();
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <!-- Modal de Edição de Autor -->
                <div id="modalAutor" class="modal">
                    <div class="modalContentAutor">
                        <span class="closeModalAutor">&times;</span>
                        <h2>Editar Autor</h2>
                        <form id="formEditarAutor" action="../php/editar_autor.php" method="POST">
                            <input type="hidden" id="edit_aut_id" name="aut_id">
                            <label for="edit_aut_nome">Nome do Autor:</label>
                            <input type="text" id="edit_aut_nome" name="aut_nome" required>
                            <button type="submit">Salvar Alterações</button>
                        </form>
                    </div>
                </div>

                <!-- Modal de Confirmação para Exclusão de Autor -->
                <div id="modalExcluirAutor" class="modal">
                    <div class="modal-content">
                        <span class="close-button" id="closeExcluirAutor">&times;</span>
                        <h2>Excluir Autor</h2>
                        <p>Tem certeza de que deseja excluir este autor?</p>
                        <form id="formExcluirAutor" method="POST">
                            <input type="hidden" id="delete_aut_id" name="aut_id">
                            <button type="submit" class="btn-excluir-edicao-noticia">Excluir</button>
                            <button type="button" id="cancelExcluirAutor"
                                class="cancelExcluirNoticias">Cancelar</button>
                        </form>
                    </div>
                </div>


                <div id="categoria">
                    <h2 class="header">Cadastro de Categorias</h2>

                    <!-- Formulário de Cadastro de Categoria -->
                    <form action="../php/cadastrar_categoria.php" method="POST" class="formCategoria">
                        <label for="cat_nome">Nome da Categoria:</label>
                        <input type="text" id="cat_nome" name="cat_nome" required>
                        <button type="submit">Cadastrar Categoria</button>
                    </form>

                    <h3>Categorias Cadastradas</h3>
                    <table id="tabelaCategorias">
                        <thead>
                            <tr>
                                <th>Nome da Categoria</th>
                                <th>Ações</th> <!-- Coluna para os botões de ação -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include('../../assets/php/info.php'); // Certifique-se de que o caminho está correto
                            
                            // Consulta para selecionar todas as categorias
                            $query = "SELECT cat_nome, cat_id FROM categoria";

                            try {
                                // Preparar e executar a consulta
                                $stmt = $pdo->prepare($query);
                                $stmt->execute();

                                // Exibir os resultados
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['cat_nome']) . "</td>";
                                    echo "<td>
    <button class='btn-editar-categoria' data-id='" . htmlspecialchars($row['cat_id']) . "' data-nome='" . htmlspecialchars($row['cat_nome']) . "'>Editar</button>
    <button class='btn-excluir-categoria' data-id='" . htmlspecialchars($row['cat_id']) . "'>Excluir</button>
</td>";
                                    echo "</tr>";

                                }
                            } catch (PDOException $e) {
                                echo "Erro na consulta: " . $e->getMessage();
                            }
                            ?>
                        </tbody>
                    </table>
                </div>


                <!-- Modal para edição de categoria -->
                <div id="modalCategoria" class="modal">
                    <div class="modalContentCategoria">
                        <span class="closeModalCategoria">&times;</span>
                        <h2>Editar Categoria</h2>
                        <form id="formEditarCategoria" action="../php/editar_categoria.php" method="POST">
                            <input type="hidden" id="cat_id" name="cat_id">
                            <label for="edit_cat_nome">Nome da Categoria:</label>
                            <input type="text" id="edit_cat_nome" name="cat_nome" required>
                            <button type="submit">Salvar Alterações</button>
                        </form>
                    </div>
                </div>

                <!-- Modal de Confirmação para Exclusão de Categoria -->
                <div id="modalExcluirCategoria" class="modal">
                    <div class="modal-content">
                        <span class="close-button" id="closeExcluirCategoria">&times;</span>
                        <h2>Excluir Categoria</h2>
                        <p>Tem certeza de que deseja excluir esta categoria?</p>
                        <form id="formExcluirCategoria" method="POST">
                            <input type="hidden" id="delete_cat_id" name="cat_id">
                            <button type="submit" class="btn-excluir-edicao-noticia">Excluir</button>
                            <button type="button" id="cancelExcluirCategoria"
                                class="cancelExcluirNoticias">Cancelar</button>
                        </form>
                    </div>
                </div>


                <div id="cupom">
                    <h2 class="header">Cadastro de Cupom</h2>

                    <button id="btnAbrirModalCupom">Cadastrar Cupom</button>

                    <div id="modalCupom" class="modalCupom">
                        <div class="modalContentCupom">
                            <span class="closeCupom">&times;</span>
                            <h2>Cadastro de Cupom</h2>
                            <form id="formCupom" action="../php/cadastrar_cupom.php" method="POST">
                                <label for="cup_codigo">Código do Cupom:</label>
                                <input type="text" id="cup_codigo" name="cup_codigo" required>

                                <label for="cup_desconto">Porcentagem do Desconto:</label>
                                <input type="number" id="cup_desconto" name="cup_desconto" step="0.01" required>

                                <label for="cup_dtvalidade">Data de Validade:</label>
                                <input type="date" id="cup_dtvalidade" name="cup_dtvalidade" required>

                                <button type="submit">Cadastrar Cupom</button>
                            </form>
                        </div>
                    </div>

                    <h3>Cupons Cadastrados</h3>
                    <table id="tabelaCupons">
                        <thead>
                            <tr>
                                <th>Código do Cupom</th>
                                <th>Porcentagem de Desconto</th>
                                <th>Data de Validade</th>
                                <th>Ações</th> <!-- Coluna para os botões de ação -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include('../../assets/php/info.php'); // Certifique-se de que o caminho está correto
                            
                            // Consulta para selecionar todos os cupons
                            $query = "SELECT cup_id, cup_codigo, cup_desconto, cup_dtvalidade FROM cupom";

                            try {
                                // Preparar e executar a consulta
                                $stmt = $pdo->prepare($query);
                                $stmt->execute();

                                // Exibir os resultados
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<tr data-id='" . htmlspecialchars($row['cup_id']) . "'>";
                                    echo "<td>" . htmlspecialchars($row['cup_codigo']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['cup_desconto']) . "%</td>";
                                    echo "<td>" . htmlspecialchars($row['cup_dtvalidade']) . "</td>";
                                    echo "<td>
                <button class='btn-editar-cupom' data-id='" . htmlspecialchars($row['cup_id']) . "' 
                data-codigo='" . htmlspecialchars($row['cup_codigo']) . "' 
                data-desconto='" . htmlspecialchars($row['cup_desconto']) . "' 
                data-validade='" . htmlspecialchars($row['cup_dtvalidade']) . "'>Editar</button>
                <button class='btn-excluir-cupom' data-id='" . htmlspecialchars($row['cup_id']) . "'>Excluir</button>
              </td>";
                                    echo "</tr>";
                                }
                            } catch (PDOException $e) {
                                echo "Erro na consulta: " . $e->getMessage();
                            }
                            ?>

                        </tbody>
                    </table>

                </div>

                <!-- Modal para Editar Cupom -->
                <div id="modalEditarCupom" class="modalEditarCupom">
                    <div class="modalContentEditarCupom">
                        <span class="closeEditarCupom">&times;</span>
                        <h2>Editar Cupom</h2>
                        <form id="formEditarCupom" action="../php/editar_cupom.php" method="POST">
                            <input type="hidden" id="edit_cup_id" name="cup_id">
                            <label for="edit_cup_codigo">Código do Cupom:</label>
                            <input type="text" id="edit_cup_codigo" name="cup_codigo" required>

                            <label for="edit_cup_desconto">Porcentagem do Desconto:</label>
                            <input type="number" id="edit_cup_desconto" name="cup_desconto" step="0.01" required>

                            <label for="edit_cup_dtvalidade">Data de Validade:</label>
                            <input type="date" id="edit_cup_dtvalidade" name="cup_dtvalidade" required>

                            <button type="submit">Salvar Alterações</button>
                        </form>
                    </div>
                </div>

                <!-- Modal de Confirmação para Exclusão de Cupom -->
                <div id="modalExcluirCupom" class="modal">
                    <div class="modal-content">
                        <span class="close-button" id="closeExcluirCupom">&times;</span>
                        <h2>Excluir Cupom</h2>
                        <p>Tem certeza de que deseja excluir este cupom?</p>
                        <form id="formExcluirCupom" method="POST">
                            <input type="hidden" id="delete_cup_id" name="cup_id">
                            <button type="submit" class="btn-excluir-edicao-noticia">Excluir</button>
                            <button type="button" id="cancelExcluirCupom"
                                class="cancelExcluirNoticias">Cancelar</button>
                        </form>
                    </div>
                </div>



                <div id="editora">
                    <h2 class="header">Cadastro de Editoras</h2>

                    <!-- Formulário de Cadastro de Editora -->
                    <form action="../php/cadastrar_editora.php" method="POST" class="formEditora">
                        <label for="edi_nome">Nome da Editora:</label>
                        <input type="text" id="edi_nome" name="edi_nome" required>

                        <button type="submit">Cadastrar Editora</button>
                    </form>

                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const formEditora = document.querySelector('.formEditora');

                            formEditora.addEventListener('submit', function (e) {
                                e.preventDefault(); // Impede o envio padrão do formulário

                                // Criar o objeto FormData com os dados do formulário
                                const formData = new FormData(this);

                                // Fazer a requisição AJAX
                                fetch(this.action, {
                                    method: 'POST',
                                    body: formData
                                })
                                    .then(response => response.text())
                                    .then(result => {
                                        if (result.trim() === 'success') {
                                            alert('Editora cadastrada com sucesso!');

                                            // Atualizar a tabela com a nova editora
                                            const ediNome = document.getElementById('edi_nome').value;

                                            const tabela = document.querySelector('#tabelaEditoras tbody');
                                            const novaLinha = document.createElement('tr');
                                            novaLinha.innerHTML = `
                            <td>${ediNome}</td>
                            <td>
                                <button class='btn-editar-editora' data-id='new' data-nome='${ediNome}'>Editar</button>
                                <button class='btn-excluir-editora' data-id='new'>Excluir</button>
                            </td>
                        `;
                                            tabela.appendChild(novaLinha);

                                            // Limpar o campo de entrada após o cadastro
                                            document.getElementById('edi_nome').value = '';
                                        } else {
                                            alert('Erro ao cadastrar a editora. Verifique os dados e tente novamente.');
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Erro na requisição:', error);
                                        alert('Erro ao processar a requisição.');
                                    });
                            });
                        });
                    </script>



                    <h3>Editoras Cadastradas</h3>
                    <table id="tabelaEditoras">
                        <thead>
                            <tr>
                                <th>Nome da Editora</th>
                                <th>Ações</th> <!-- Coluna para os botões de ação -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include('../../assets/php/info.php'); // Certifique-se de que o caminho está correto
                            
                            // Consulta para selecionar todas as editoras
                            $query = "SELECT edi_id, edi_nome FROM editora";

                            try {
                                // Preparar e executar a consulta
                                $stmt = $pdo->prepare($query);
                                $stmt->execute();

                                // Exibir os resultados
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<tr data-id='" . htmlspecialchars($row['edi_id']) . "'>"; // Adicionado data-id
                                    echo "<td>" . htmlspecialchars($row['edi_nome']) . "</td>";
                                    echo "<td>
                <button class='btn-editar-editora' data-id='" . htmlspecialchars($row['edi_id']) . "' data-nome='" . htmlspecialchars($row['edi_nome']) . "'>Editar</button>
                <button class='btn-excluir-editora' data-id='" . htmlspecialchars($row['edi_id']) . "'>Excluir</button>
              </td>";
                                    echo "</tr>";
                                }
                            } catch (PDOException $e) {
                                echo "Erro na consulta: " . $e->getMessage();
                            }
                            ?>

                        </tbody>
                    </table>
                </div>

                <!-- Modal para editar editora -->
                <div id="modalEditora" class="modalEditora">
                    <div class="modalEditora-content">
                        <span class="closeModalEditora">&times;</span>
                        <h2>Editar Editora</h2>
                        <form id="formEditarEditora" action="../php/editar_editora.php" method="POST">
                            <input type="hidden" id="edit_edi_id" name="edi_id">
                            <label for="edit_edi_nome">Nome da Editora:</label>
                            <input type="text" id="edit_edi_nome" name="edi_nome" required>
                            <button type="submit">Salvar Alterações</button>
                        </form>
                    </div>
                </div>

                <!-- Modal de Confirmação para Exclusão de Editora -->
                <div id="modalExcluirEditora" class="modal">
                    <div class="modal-content">
                        <span class="close-button" id="closeExcluirEditora">&times;</span>
                        <h2>Excluir Editora</h2>
                        <p>Tem certeza de que deseja excluir esta editora?</p>
                        <form id="formExcluirEditora" method="POST">
                            <input type="hidden" id="delete_edi_id" name="edi_id">
                            <button type="submit" class="btn-excluir-edicao-noticia">Excluir</button>
                            <button type="button" id="cancelExcluirNoticias">Cancelar</button>
                        </form>
                    </div>
                </div>


                <div id="noticias">
                    <h2 class="header">Cadastro de Notícias</h2>

                    <button id="btnAbrirModalNoticias">Cadastrar Notícia</button>


                    <div id="modalNoticias" class="modal">
                        <div class="modal-content">
                            <span class="close-button">&times;</span>
                            <h2>Cadastro de Notícia</h2>
                            <form id="formNoticias" action="../php/cadastrar_noticia.php" method="POST"
                                enctype="multipart/form-data">
                                <label for="not_titulo">Título da Notícia:</label>
                                <input type="text" id="not_titulo" name="not_titulo" required>

                                <label for="not_resumo">Resumo da Notícia:</label>
                                <textarea id="not_resumo" name="not_resumo" required></textarea>

                                <label for="not_desc">Descrição da Notícia (você pode pular linhas e formatar):</label>
                                <textarea id="not_desc" name="not_desc" required></textarea>


                                <label for="not_resp">Responsável pela Notícia:</label>
                                <select id="not_resp" name="not_resp" required>
                                    <option value="" disabled selected>Selecione um responsável</option>
                                    <!-- Opções são preenchidas dinamicamente pelo PHP -->
                                    <?php
                                    include('../../assets/php/info.php');
                                    try {
                                        $query = "SELECT adm_nome FROM admin";
                                        $stmt = $pdo->prepare($query);
                                        $stmt->execute();

                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            echo "<option value='" . htmlspecialchars($row['adm_nome']) . "'>" . htmlspecialchars($row['adm_nome']) . "</option>";
                                        }
                                    } catch (PDOException $e) {
                                        echo "<option value='' disabled>Erro ao carregar responsáveis</option>";
                                    }
                                    ?>
                                </select>

                                <label for="not_dtcriacao">Data de Criação:</label>
                                <input type="date" id="not_dtcriacao" name="not_dtcriacao" required>

                                <label for="not_img">Imagem da Notícia (Tamanho recomendado: 1920 x 1080):</label>
                                <input type="file" id="not_img" name="not_img" accept="image/*" required>

                                <label for="not_prioridade">
                                    <input type="checkbox" id="not_prioridade" name="not_prioridade">
                                    Definir como Prioridade
                                </label>


                                <button type="submit">Cadastrar Notícia</button>
                            </form>
                        </div>
                    </div>

                    <h3>Notícias Cadastradas</h3>
                    <table id="tabelaNoticias">
                        <thead>
                            <tr>
                                <th>Título</th>
                                <th>Resumo</th>
                                <th>Responsável</th>
                                <th>Data de Criação</th>
                                <th>Prioridade</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT not_id, not_titulo, not_resumo, not_resp, not_dtcriacao, not_prioridade FROM noticias";

                            try {
                                $stmt = $pdo->prepare($query);
                                $stmt->execute();

                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<tr data-id='" . htmlspecialchars($row['not_id']) . "'>";
                                    echo "<td>" . htmlspecialchars($row['not_titulo']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['not_resumo']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['not_resp']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['not_dtcriacao']) . "</td>";
                                    echo "<td>" . ($row['not_prioridade'] ? 'Sim' : 'Não') . "</td>";
                                    echo "<td>
                        <button class='btn-editar-noticia' data-id='" . htmlspecialchars($row['not_id']) . "'>Editar</button>
                        <button class='btn-excluir-noticia' data-id='" . htmlspecialchars($row['not_id']) . "'>Excluir</button>
                    </td>";
                                    echo "</tr>";
                                }
                            } catch (PDOException $e) {
                                echo "Erro na consulta: " . $e->getMessage();
                            }
                            ?>
                        </tbody>
                    </table>

                    <!-- Modal de Noticias - Editar -->
                    <div id="modalEditarNoticias" class="modal">
                        <div class="modal-content">
                            <span class="close-button" id="closeEditarNoticias">&times;</span>
                            <h2>Editar Notícia</h2>
                            <form id="formEditarNoticias" method="POST">
                                <input type="hidden" id="edit_not_id" name="not_id">

                                <label for="edit_not_titulo">Título da Notícia:</label>
                                <input type="text" id="edit_not_titulo" name="not_titulo" required>

                                <label for="edit_not_resumo">Resumo da Notícia:</label>
                                <textarea id="edit_not_resumo" name="not_resumo" required></textarea>

                                <label for="edit_not_desc">Descrição da Notícia:</label>
                                <textarea id="edit_not_desc" name="not_desc" required></textarea>

                                <label for="edit_not_resp">Responsável pela Notícia:</label>
                                <select id="edit_not_resp" name="not_resp" required>
                                    <option value="" disabled>Selecione um responsável</option>
                                    <?php
                                    // Reutilizando o código PHP para carregar os responsáveis
                                    include('../../assets/php/info.php');
                                    try {
                                        $query = "SELECT adm_nome FROM admin";
                                        $stmt = $pdo->prepare($query);
                                        $stmt->execute();

                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            echo "<option value='" . htmlspecialchars($row['adm_nome']) . "'>" . htmlspecialchars($row['adm_nome']) . "</option>";
                                        }
                                    } catch (PDOException $e) {
                                        echo "<option value='' disabled>Erro ao carregar responsáveis</option>";
                                    }
                                    ?>
                                </select>

                                <label for="edit_not_prioridade">
                                    <input type="checkbox" id="edit_not_prioridade" name="not_prioridade"
                                        class="not_prioridade">
                                    Definir como Prioridade
                                </label>

                                <button type="submit">Salvar Alterações</button>
                            </form>
                        </div>
                    </div>

                    <!-- Modal de Confirmação para Exclusão -->
                    <div id="modalExcluirNoticias" class="modal">
                        <div class="modal-content">
                            <span class="close-button" id="closeExcluirNoticias">&times;</span>
                            <h2>Excluir Notícia</h2>
                            <p>Tem certeza de que deseja excluir esta notícia?</p>
                            <form id="formExcluirNoticias" method="POST">
                                <input type="hidden" id="delete_not_id" name="not_id">
                                <button type="submit" class="btn-excluir-edicao-noticia">Excluir</button>
                                <button type="button" id="cancelExcluirNoticias">Cancelar</button>
                            </form>
                        </div>
                    </div>


                </div>



            </div>
            <ul class="statusbar">
                <li><a href=""></a></li>
                <li><a href=""></a></li>
                <li class="profiles-setting"><a href="">s</a></li>
                <li class="logout"><a href="">k</a></li>
            </ul>
        </div>
    </div>
</body>

</html>