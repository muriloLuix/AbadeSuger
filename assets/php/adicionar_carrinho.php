<?php
session_start();
include 'info.php';  // Conexão com o banco de dados

$data = json_decode(file_get_contents('php://input'), true);
$livroId = $data['liv_id'];
$clienteId = $data['cli_id'];
$livroPreco = $data['liv_preco'];

// Verificar se os dados foram recebidos corretamente
if (empty($livroId) || empty($clienteId) || empty($livroPreco)) {
    echo json_encode(['status' => 'erro', 'message' => 'Dados inválidos.']);
    exit;
}

// Verificar se o livro já foi adicionado ao carrinho
$sqlCheck = "SELECT * FROM carrinho WHERE cli_id = :cli_id AND liv_id = :liv_id";
$stmtCheck = $pdo->prepare($sqlCheck);
$stmtCheck->bindParam(':cli_id', $clienteId);
$stmtCheck->bindParam(':liv_id', $livroId);
$stmtCheck->execute();

if ($stmtCheck->rowCount() > 0) {
    echo json_encode(['status' => 'sucesso', 'message' => 'Livro já no carrinho']);
    exit;
}

// Inserir o livro no carrinho
$sql = "INSERT INTO carrinho (cli_id, liv_id, liv_preco) VALUES (:cli_id, :liv_id, :liv_preco)";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':cli_id', $clienteId);
$stmt->bindParam(':liv_id', $livroId);
$stmt->bindParam(':liv_preco', $livroPreco);

if ($stmt->execute()) {
    echo json_encode(['status' => 'sucesso']);
} else {
    echo json_encode(['status' => 'erro', 'message' => 'Falha ao inserir no banco de dados.']);
}
