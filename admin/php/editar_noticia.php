<?php
include('../../assets/php/info.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $not_id = $_POST['not_id'];
    $not_titulo = $_POST['not_titulo'];
    $not_resumo = $_POST['not_resumo'];
    $not_desc = $_POST['not_desc'];
    $not_resp = $_POST['not_resp'];
    $not_prioridade = isset($_POST['not_prioridade']) ? 1 : 0;

    try {
        $query = "UPDATE noticias 
                  SET not_titulo = :not_titulo, 
                      not_resumo = :not_resumo, 
                      not_desc = :not_desc, 
                      not_resp = :not_resp, 
                      not_prioridade = :not_prioridade, 
                      not_dtatualizacao = NOW() -- Atualiza a data para o momento da edição
                  WHERE not_id = :not_id";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':not_id', $not_id, PDO::PARAM_INT);
        $stmt->bindParam(':not_titulo', $not_titulo);
        $stmt->bindParam(':not_resumo', $not_resumo);
        $stmt->bindParam(':not_desc', $not_desc);
        $stmt->bindParam(':not_resp', $not_resp);
        $stmt->bindParam(':not_prioridade', $not_prioridade, PDO::PARAM_BOOL);
        $stmt->execute();

        echo 'success';
    } catch (PDOException $e) {
        echo 'Erro: ' . $e->getMessage();
    }
}
?>