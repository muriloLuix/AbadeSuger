<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/login.css">
    <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon">
    <!-- Scripts -->
    <script src="../js/seePassword.js" defer></script>
    <script src="../js/modalLogin.js" defer></script>
    <!-- Scripts -->
    <!-- BootStrap Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- BootStrap Icon -->

    <title> | Faça seu login</title>
</head>

<body>
    <a href="../../index.php" class="backToMain">
        <div class="logoAbade">
            <img src="../img/logoMenu.svg" alt="Logo">
        </div><!--logoAbade-->
        <div class="text">
            <p>Voltar para a página inicial</p>
        </div><!--text-->
    </a><!--backToMain-->

    <main>
        <div class="container">
            <div class="blackTransparent" id="blackTransparent">
                <div class="form-container">
                    <h1>REALIZE SEU LOGIN</h1>
                    <p>Seja bem-vindo!</p>
                    <form id="login-form">
                        <div class="input-container">
                            <input type="text" id="cli_login" name="cli_login" placeholder=" " required>
                            <label for="cli_login">Seu Login</label>
                        </div>
                        <div class="input-container password-container">
                            <input type="password" id="cli_senha" name="cli_senha" placeholder=" " required>
                            <label for="cli_senha">Sua Senha</label>
                            <span class="toggle-password">
                                <i class="bi bi-eye-fill" onclick="showPassword()" id="btnPassword"></i>
                            </span>
                        </div>
                        <button type="submit">Entrar</button>
                    </form>

                    <!-- Adicionando o link para o cadastro -->
                    <div class="register-link">
                        <p>Ainda não tem cadastro? <a href="register.html">Faça o seu!</a></p>
                    </div>
                </div>
            </div>

            <div class="logoAbadeSuger">
                <img src="../img/iconesCadastro/LogoAbadeSuger.svg" alt="">
            </div>
        </div>

        <!-- Modal de erro -->
        <div class="modal" id="errorModal">
            <div class="modal-content">
                <p id="errorMessage"></p>
                <button id="closeModalButton" onclick="closeModal()">Fechar</button>
            </div>
        </div>

    </main>
    <!-- Modal de erro -->
    <div id="modal-erro" class="modal">
        <div class="modal-content">
            <p id="erro-msg">Login ou senha incorretos!</p>
            <button type="button" onclick="fecharModal('modal-erro')">OK</button>
        </div>
    </div>

    <!-- Modal de sucesso -->
    <div id="modal-sucesso" class="modal">
        <div class="modal-content">
            <p>Login realizado com sucesso!</p>
            <button type="button" id="btn-ok-sucesso">OK</button>
        </div>
    </div>


</body>

</html>