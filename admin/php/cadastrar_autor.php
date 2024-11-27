<?php
include('../../assets/php/info.php'); // Certifique-se de que o caminho está correto

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $aut_nome = $_POST['aut_nome'];

    // Inserir autor no banco de dados
    $query = "INSERT INTO autor (aut_nome) VALUES (:aut_nome)";
    try {
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':aut_nome', $aut_nome);
        $stmt->execute();

        // Recuperar o ID do autor recém-cadastrado
        $aut_id = $pdo->lastInsertId();

        // Retornar o ID e o nome do autor na resposta JSON
        echo json_encode(["success" => true, "id" => $aut_id, "nome" => $aut_nome]);
    } catch (PDOException $e) {
        // Caso ocorra um erro, retorna a mensagem de erro
        echo json_encode(["success" => false, "message" => "Erro ao cadastrar o autor: " . $e->getMessage()]);
    }
}
?>