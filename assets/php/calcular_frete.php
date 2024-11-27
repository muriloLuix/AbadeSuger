<?php
session_start();

$data = json_decode(file_get_contents('php://input'), true);
$cep = $data['cep'];
$frete = $data['frete'];

if (!isset($cep, $frete)) {
    echo json_encode(['status' => 'error', 'message' => 'Dados inválidos.']);
    exit;
}

try {
    // Exemplo de armazenamento no banco de dados
    require 'info.php';
    $query = "INSERT INTO transporte (user_id, cep, frete) VALUES (:user_id, :cep, :frete)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->bindParam(':cep', $cep, PDO::PARAM_STR);
    $stmt->bindParam(':frete', $frete, PDO::PARAM_STR);
    $stmt->execute();

    echo json_encode(['status' => 'success']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>