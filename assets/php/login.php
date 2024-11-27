<?php
ob_start();
include('info.php'); // Conexão com o banco
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cli_login = $_POST['cli_login'] ?? '';
    $cli_senha = $_POST['cli_senha'] ?? '';

    error_log("Tentativa de login para: $cli_login");

    $stmt = $pdo->prepare('SELECT * FROM clientes WHERE cli_login = :cli_login');
    if (!$stmt->execute([':cli_login' => $cli_login])) {
        error_log("Erro SQL: " . implode(", ", $stmt->errorInfo()));
        ob_end_clean();
        echo json_encode(['success' => false, 'message' => 'Erro no servidor.']);
        exit();
    }
    $user = $stmt->fetch();

    if ($user && password_verify($cli_senha, $user['cli_senha'])) {
        $_SESSION['user_id'] = $user['cli_id'];
        $_SESSION['user_name'] = $user['cli_nome'];
        $_SESSION['user_login'] = $user['cli_login'];

        ob_end_clean();
        echo json_encode(['success' => true, 'redirect' => '../html/nossaloja.php']);
    } else {
        ob_end_clean();
        echo json_encode(['success' => false, 'message' => 'Login ou senha incorretos!']);
    }
    exit();
}

ob_end_clean();
echo json_encode(['success' => false, 'message' => 'Método não permitido.']);
exit();
