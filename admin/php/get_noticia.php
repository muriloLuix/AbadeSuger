<?php
include('../../assets/php/info.php');

if (isset($_GET['id'])) {
    $not_id = $_GET['id'];

    try {
        $query = "SELECT not_id, not_titulo, not_resumo, not_desc, not_resp, not_prioridade FROM noticias WHERE not_id = :not_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':not_id', $not_id, PDO::PARAM_INT);
        $stmt->execute();

        $noticia = $stmt->fetch(PDO::FETCH_ASSOC);

        echo json_encode($noticia);
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
}
?>
