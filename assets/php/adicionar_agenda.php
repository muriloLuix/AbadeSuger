<?php
include('../../assets/php/info.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $not_id = $_POST['not_id'];
    $not_titulo = $_POST['not_titulo'];

    try {
        // Verificar se a notícia já está na agenda
        $queryCheck = "SELECT * FROM AGENDA WHERE not_id = :not_id";
        $stmtCheck = $pdo->prepare($queryCheck);
        $stmtCheck->bindParam(':not_id', $not_id, PDO::PARAM_INT);
        $stmtCheck->execute();

        if ($stmtCheck->rowCount() > 0) {
            echo 'Esta notícia já está na sua agenda.';
            exit;
        }

        // Inserir a notícia na tabela AGENDA
        $query = "INSERT INTO AGENDA (not_id, not_titulo) VALUES (:not_id, :not_titulo)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':not_id', $not_id, PDO::PARAM_INT);
        $stmt->bindParam(':not_titulo', $not_titulo);
        $stmt->execute();

        echo 'success';
    } catch (PDOException $e) {
        echo 'Erro ao adicionar à agenda: ' . $e->getMessage();
    }
}
?>
