<?php
include('../../assets/php/info.php'); // Conexão com o banco de dados

// Verificar se o ID foi passado via POST
if (isset($_POST['cat_id'])) {
    $cat_id = $_POST['cat_id'];

    // Preparar a consulta para excluir a categoria com o ID recebido
    $query = "DELETE FROM categoria WHERE cat_id = :id";

    try {
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $cat_id, PDO::PARAM_INT);
        $stmt->execute();

        // Retorno de sucesso
        echo "success";
    } catch (PDOException $e) {
        echo "Erro ao excluir a categoria: " . $e->getMessage();
    }
} else {
    echo "ID não recebido!";
}
?>
