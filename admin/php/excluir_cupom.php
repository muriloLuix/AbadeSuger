<?php
include('../../assets/php/info.php'); // Conexão com o banco de dados

// Verificar se o ID foi passado via POST
if (isset($_POST['cup_id'])) {
    $cup_id = $_POST['cup_id'];

    // Preparar a consulta para excluir o cupom com o ID recebido
    $query = "DELETE FROM cupom WHERE cup_id = :id";

    try {
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $cup_id, PDO::PARAM_INT);
        $stmt->execute();

        // Retorno de sucesso
        echo "success";
    } catch (PDOException $e) {
        echo "Erro ao excluir o cupom: " . $e->getMessage();
    }
} else {
    echo "ID não recebido!";
}
?>
