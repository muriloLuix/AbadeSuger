<?php
include('../../assets/php/info.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $not_id = $_POST['not_id'];

    try {
        // Exclui a notícia e, automaticamente, todos os registros relacionados
        $query = "DELETE FROM noticias WHERE not_id = :not_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':not_id', $not_id, PDO::PARAM_INT);
        $stmt->execute();

        echo 'success';
    } catch (PDOException $e) {
        echo 'Erro: ' . $e->getMessage();
    }
}
?>
