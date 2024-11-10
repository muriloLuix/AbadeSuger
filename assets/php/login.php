<?php
// Inclui a conexão com o banco de dados
include('info.php');

// Inicia a sessão para manter o estado do login
session_start();

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recebe os dados do formulário
    $cli_login = $_POST['cli_login'];
    $cli_senha = $_POST['cli_senha'];

    // Consulta no banco de dados para verificar se o usuário existe
    $stmt = $pdo->prepare("SELECT * FROM clientes WHERE cli_login = :cli_login");
    $stmt->execute([':cli_login' => $cli_login]);
    $user = $stmt->fetch();

    // Verifica se o usuário foi encontrado e se a senha está correta
    if ($user && password_verify($cli_senha, $user['cli_senha'])) {
        // Senha correta, cria a sessão de login
        $_SESSION['user_id'] = $user['cli_id'];
        $_SESSION['user_name'] = $user['cli_nome'];
        $_SESSION['user_login'] = $user['cli_login']; // Armazene o login como 'user_login'

        // Redireciona o usuário para a página inicial ou área protegida
        header("Location: ../html/nossaloja.php"); // Substitua pelo seu redirecionamento
        exit();
    } else {
        // Se a senha estiver incorreta ou o usuário não existir
        $error_message = "Login ou senha incorretos!";
    }
}
?>

<!-- Exibe a mensagem de erro, caso haja -->
<?php if (isset($error_message)) : ?>
    <div class="error-message">
        <p><?php echo $error_message; ?></p>
    </div>
<?php endif; ?>
