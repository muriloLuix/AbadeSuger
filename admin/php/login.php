<?php
require '../../assets/php/info.php';
session_start(); // Inicia a sessão

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recebe os dados do formulário
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Verifica se o e-mail existe
    $sql = "SELECT * FROM admin WHERE adm_email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($senha, $user['adm_senha'])) {
        // Armazena os dados na sessão
        $_SESSION['adm_id'] = $user['adm_id']; // ID do admin
        $_SESSION['adm_nome'] = $user['adm_nome']; // Nome do admin
        $_SESSION['adm_email'] = $user['adm_email']; // Email do admin

        // Login bem-sucedido, redireciona para o dashboard
        header("Location: ../html/dashboard.php");
        exit();
    } else {
        echo "E-mail ou senha incorretos!";
    }
}
?>
