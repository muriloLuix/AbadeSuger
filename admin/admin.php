<?php
// Verifique se o parâmetro de sucesso foi passado via URL
$cadastro_sucesso = isset($_GET['cadastro']) && $_GET['cadastro'] == 'sucesso';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Favicon -->
    <link rel="shortcut icon" href="../assets/img/favicon.png" type="image/x-icon">
    <!-- Favicon -->
    <!-- Script -->
    <script src="js/login.js" defer></script>
    <script src="js/password.js" defer></script>
    <!-- Script -->
    <!-- Css -->
    <link rel="stylesheet" href="css/admin.css">
    <!-- Css -->
    <title> Admin - Abade Suger</title>
</head>

<body>
    <h2>Admin - Abade Suger</h2>
    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form action="php/cadastro.php" method="POST" id="signup-form">
                <h1>Crie sua conta</h1>
                <span>Use seu e-mail de cadastro</span>
                <input type="text" name="nome" placeholder="Nome completo" required />
                <input type="email" name="email" placeholder="Email" required />
                <div class="password-container">
                    <input type="password" name="senha" id="signUpPassword" placeholder="Senha" required />
                    <span class="eye-icon" id="toggleSignUpPassword">&#128065;</span>
                </div>
                <button type="submit">Registrar</button>
            </form>
        </div>

        <div id="successModal" class="modal" style="display: none;">
            <div class="modal-content">
                <span class="close" id="closeModal">&times;</span>
                <p>Cadastro realizado com sucesso!</p>
            </div>
        </div>

        <div class="form-container sign-in-container">
            <form action="php/login.php" method="POST">
                <h1>Faça seu login</h1>
                <span>Use sua conta de acesso</span>
                <input type="email" name="email" placeholder="Email" required />
                <div class="password-container">
                    <input type="password" name="senha" id="signInPassword" placeholder="Senha" required />
                    <span class="eye-icon" id="toggleSignInPassword">&#128065;</span>
                </div>
                <a href="#">Esqueceu sua senha?</a>
                <button type="submit">Entrar</button>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Seja bem vindo novamente!</h1>
                    <p>Para se manter conectado conosco, faça login com suas informações pessoais</p>
                    <button class="ghost" id="signIn">Logar</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Olá, usuário!</h1>
                    <p>Caso não tenha conta, insira sua credenciais clicando no botão abaixo!</p>
                    <button class="ghost" id="signUp">Registre-se</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Função para alternar a visibilidade da senha no cadastro
        document.getElementById('toggleSignUpPassword').addEventListener('click', function () {
            const passwordField = document.getElementById('signUpPassword');
            if (passwordField.type === "password") {
                passwordField.type = "text";
            } else {
                passwordField.type = "password";
            }
        });

        // Função para alternar a visibilidade da senha no login
        document.getElementById('toggleSignInPassword').addEventListener('click', function () {
            const passwordField = document.getElementById('signInPassword');
            if (passwordField.type === "password") {
                passwordField.type = "text";
            } else {
                passwordField.type = "password";
            }
        });

        // Exibir o modal de sucesso após o cadastro
        <?php if ($cadastro_sucesso) { ?>
            document.getElementById('successModal').style.display = "block";
        <?php } ?>

        // Fechar o modal
        document.getElementById('closeModal').addEventListener('click', function () {
            document.getElementById('successModal').style.display = "none";
        });
    </script>

</body>

</html>