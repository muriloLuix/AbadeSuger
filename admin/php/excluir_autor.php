<?php
include('../../assets/php/info.php'); // Conexão com o banco de dados

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['aut_id'])) {
    $autorId = $_POST['aut_id'];

    try {
        // Exclui o autor do banco de dados
        $query = "DELETE FROM autor WHERE aut_id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $autorId, PDO::PARAM_INT);
        $stmt->execute();

        // Retorna sucesso como resposta JSON
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        // Retorna erro como resposta JSON
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'ID do autor não encontrado.']);
}
?>