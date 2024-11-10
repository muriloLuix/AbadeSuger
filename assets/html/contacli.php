<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redireciona para a tela de login se não estiver logado
    exit();
}

// Inclui a conexão com o banco de dados
include('../php/info.php');

// Pega o ID do usuário logado
$user_id = $_SESSION['user_id'];

// Consulta os dados do usuário
$query = "SELECT * FROM clientes WHERE cli_id = :user_id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();

// Verifica se o usuário existe
if ($stmt->rowCount() > 0) {
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    // Caso o usuário não seja encontrado
    $error_message = "Usuário não encontrado!";
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Boostrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Boostrap -->
    <!-- Css -->
    <link rel="stylesheet" href="../css/contacli.css">
    <!-- Css -->
    <title> | Minha conta</title>
</head>

<body>
    <div class="generalHeader">
        <div class="menu-hamburger">
            <div class="menu-toggle" id="menu-toggle">
                <div class="hamburger"></div>
            </div>
        </div>
        <div class="logo">
            <a href="../../index.html"><img src="../img/contacli/NossaLojaBanner.svg" alt="Logo Header"></a>
        </div>
        <div class="icons">
            <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bag"
                    viewBox="0 0 16 16">
                    <path
                        d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1m3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1z" />
                </svg>
                <span class="badge" id="bag-badge">0</span>
                <span>Sua Sacola</span>
            </div>
            <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart"
                    viewBox="0 0 16 16">
                    <path
                        d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15" />
                </svg>
                <span class="badge" id="favorites-badge">0</span>
                <span>Favoritos</span>
            </div>
            <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person"
                    viewBox="0 0 16 16">
                    <path
                        d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z" />
                </svg>
                <span>Conta</span>
            </div>
        </div>
    </div>
    <main>
        <div class="containerGeneral">
            <aside class="leftMenu">
                <div class="username">
                    <div class="iconUser">
                        <i class="bi bi-person"></i>
                    </div>
                    <div class="nameUser">
                        <span>Seja bem-vindo</span>
                        <p>nome do usu</p>
                    </div>
                </div>
                <div class="itens">
                    <nav>
                        <ul>
                            <li>Perfil</li>
                            <li>Pedidos</li>
                            <li><svg width="26" height="42" viewBox="0 0 26 42" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M8.55634 32.001L9.43899 22.2917C9.49832 21.6391 8.92513 21.0989 8.27321 21.1656C6.07083 21.391 1.76256 21.5593 1.30676 19.503C0.968861 17.9785 2.57589 16.3055 3.7245 15.3329C4.24034 14.8961 4.27852 14.0633 3.79215 13.5939C2.39842 12.2488 0.184852 9.70453 1.30676 8.00296C2.37563 6.38185 5.58378 7.06374 7.35279 7.59484C7.97348 7.78119 8.65157 7.38773 8.79269 6.75523C9.24913 4.70938 10.4242 0.8785 12.8068 1.00296C15.0787 1.12164 16.1558 4.72369 16.5786 6.7131C16.7158 7.35867 17.4116 7.76428 18.0428 7.57142C19.7477 7.05045 22.7325 6.42615 23.8068 8.00296C24.9856 9.73317 22.4963 12.1058 20.7717 13.454C20.1529 13.9377 20.2119 14.9723 20.8693 15.4019C22.3049 16.3399 24.1605 17.8957 23.8068 19.503C23.356 21.5509 19.0819 21.3928 16.8696 21.1687C16.2083 21.1018 15.6311 21.6588 15.7062 22.3192L16.8068 32.0015M12.5563 31.5005V35.7502V40M12.5563 40L17.5563 36.5005M12.5563 40L7.55634 36.5005"
                                        stroke="#3E30AB" stroke-width="2" stroke-linecap="round" />
                                </svg>
                                Sua biblioteca</li>
                            <li><a href="../php/logout.php">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M9 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H9"
                                            stroke="#3E30AB" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M16 17L21 12L16 7" stroke="#3E30AB" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M21 12H9" stroke="#3E30AB" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                    Sair da conta
                                </a></li>

                        </ul>
                    </nav>
                </div>
            </aside>
            <div class="containerCentered">
                <div class="title">PERFIL</div>
                <div class="centeredInformations">
                    <div class="names">
                        <div class="nomeUsu">
                            <span>Nome</span>
                            <p><?php echo htmlspecialchars($user['cli_nome']); ?></p> <!-- Exibe nome do usuário -->
                        </div>
                        <div class="sobrenomeUsu">
                            <span>Sobrenome</span>
                            <p><?php echo htmlspecialchars($user['cli_sobrenome']); ?></p>
                            <!-- Exibe sobrenome do usuário -->
                        </div>
                    </div>
                    <div class="email_senha">
                        <div class="email">
                            <span>Email</span>
                            <p><?php echo htmlspecialchars($user['cli_email']); ?></p> <!-- Exibe email do usuário -->
                        </div>
                        <div class="senha">
                            <span>Senha</span>
                            <p>******</p> <!-- Não exibe a senha diretamente -->
                        </div>
                    </div>
                    <div class="documents">
                        <div class="documento">
                            <span>Documento</span>
                            <p><?php echo isset($user['cli_cpf']) ? htmlspecialchars($user['cli_cpf']) : 'Documento não disponível'; ?>
                            </p>
                        </div>
                        <div class="telefone">
                            <span>Telefone</span>
                            <p><?php echo htmlspecialchars($user['cli_telefone']); ?></p>
                        </div>
                        <div class="endereco">
                            <span>Endereço</span>
                            <p>
                                <?php
                                // Concatenando os campos do endereço
                                $endereco = htmlspecialchars($user['cli_rua']) . ', ';
                                $endereco .= htmlspecialchars($user['cli_numero']) . ', ';
                                $endereco .= !empty($user['cli_complemento']) ? htmlspecialchars($user['cli_complemento']) . ', ' : '';
                                $endereco .= htmlspecialchars($user['cli_bairro']) . ', ';
                                $endereco .= htmlspecialchars($user['cli_cidade']);

                                echo $endereco;
                                ?>
                            </p>
                        </div>
                    </div>


                </div>
                <div class="button">
                    <button type="submit">
                        Editar
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 20H21" stroke="white" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path
                                d="M16.5 3.49998C16.8978 3.10216 17.4374 2.87866 18 2.87866C18.2786 2.87866 18.5544 2.93353 18.8118 3.04014C19.0692 3.14674 19.303 3.303 19.5 3.49998C19.697 3.69697 19.8532 3.93082 19.9598 4.18819C20.0665 4.44556 20.1213 4.72141 20.1213 4.99998C20.1213 5.27856 20.0665 5.55441 19.9598 5.81178C19.8532 6.06915 19.697 6.303 19.5 6.49998L7 19L3 20L4 16L16.5 3.49998Z"
                                fill="white" stroke="white" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>
            </div>

        </div>
    </main>
</body>

</html>