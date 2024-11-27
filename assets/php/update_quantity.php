<?php
session_start();
require 'info.php';

$data = json_decode(file_get_contents('php://input'), true);
$carrinhoId = $data['carrinhoId']; // Corrigido: Buscar o ID correto
$quantidade = $data['quantidade'];

if (!isset($carrinhoId, $quantidade) || $quantidade < 1) {
    echo json_encode(['status' => 'error', 'message' => 'Dados inválidos.']);
    exit;
}

try {
    // Atualizar a quantidade no banco de dados
    $query = "UPDATE carrinho SET car_quantidade = :quantidade WHERE car_id = :carrinho_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':quantidade', $quantidade, PDO::PARAM_INT);
    $stmt->bindParam(':carrinho_id', $carrinhoId, PDO::PARAM_INT);
    $stmt->execute();

    // Recalcular o subtotal global
    $cli_id = $_SESSION['user_id'];
    $querySubtotal = "
        SELECT SUM(carrinho.car_quantidade * carrinho.liv_preco) AS subtotal
        FROM carrinho
        WHERE carrinho.cli_id = :cli_id
    ";
    $stmtSubtotal = $pdo->prepare($querySubtotal);
    $stmtSubtotal->bindParam(':cli_id', $cli_id, PDO::PARAM_INT);
    $stmtSubtotal->execute();
    $subtotal = $stmtSubtotal->fetchColumn();

    echo json_encode(['status' => 'success', 'subtotal' => $subtotal]);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
