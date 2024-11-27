<?php
include('../../assets/php/info.php'); // Certifique-se de que o caminho está correto

// Recebe os dados via POST
$autorId = $_POST['aut_id'];
$novoNome = $_POST['aut_nome'];

try {
    // Atualiza o nome do autor no banco
    $query = "UPDATE autor SET aut_nome = :nome WHERE aut_id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':nome', $novoNome);
    $stmt->bindParam(':id', $autorId);
    $stmt->execute();

    // Retorna sucesso como resposta JSON
    echo json_encode(['success' => true, 'id' => $autorId]);
} catch (PDOException $e) {
    // Retorna erro como resposta JSON
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
