<?php
include('../../assets/php/info.php'); // Conexão com o banco de dados

// Verificar se o ID foi passado via POST
if (isset($_POST['id'])) {
    $edi_id = $_POST['id'];

    // Preparar a consulta para excluir a editora com o ID recebido
    $query = "DELETE FROM editora WHERE edi_id = :id";

    try {
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $edi_id, PDO::PARAM_INT);
        $stmt->execute();

        // Retorno de sucesso
        echo "success";
    } catch (PDOException $e) {
        echo "Erro ao excluir a editora: " . $e->getMessage();
    }
} else {
    echo "ID não recebido!";
}
?>