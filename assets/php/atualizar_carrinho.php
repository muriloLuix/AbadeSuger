<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'erro', 'message' => 'Usuário não logado.']);
    exit;
}

require 'info.php';

try {
    $data = json_decode(file_get_contents('php://input'), true);

    $carrinhoId = $data['carrinhoId'] ?? null;
    $novaQuantidade = $data['quantidade'] ?? null;

    if (empty($carrinhoId) || $novaQuantidade === null || $novaQuantidade < 1) {
        echo json_encode(['status' => 'erro', 'message' => 'Dados inválidos ou quantidade menor que 1.']);
        exit;
    }

    // Atualizar a quantidade no banco
    $sql = "UPDATE carrinho SET car_quantidade = :quantidade WHERE car_id = :car_id AND cli_id = :cli_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':quantidade', $novaQuantidade, PDO::PARAM_INT);
    $stmt->bindParam(':car_id', $carrinhoId, PDO::PARAM_INT);
    $stmt->bindParam(':cli_id', $_SESSION['user_id'], PDO::PARAM_INT);

    if ($stmt->execute()) {
        // Calcular o subtotal atualizado
        $sqlSubtotal = "SELECT SUM(c.car_quantidade * l.liv_preco) as subtotal
                        FROM carrinho c
                        JOIN livros l ON c.liv_id = l.liv_id
                        WHERE c.cli_id = :cli_id";
        $stmtSubtotal = $pdo->prepare($sqlSubtotal);
        $stmtSubtotal->bindParam(':cli_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmtSubtotal->execute();

        $result = $stmtSubtotal->fetch(PDO::FETCH_ASSOC);
        $subtotal = $result['subtotal'] ?? 0;

        echo json_encode([
            'status' => 'sucesso',
            'message' => 'Quantidade atualizada com sucesso.',
            'subtotal' => number_format($subtotal, 2, ',', '.')
        ]);
    } else {
        echo json_encode(['status' => 'erro', 'message' => 'Erro ao atualizar a quantidade.']);
    }


} catch (Exception $e) {
    echo json_encode(['status' => 'erro', 'message' => $e->getMessage()]);
}
