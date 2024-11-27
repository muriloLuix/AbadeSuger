<?php
include('../../assets/php/info.php'); // Certifique-se de que o caminho está correto

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $edi_nome = $_POST['edi_nome'] ?? '';

    // Verificar se o nome da editora foi enviado
    if (empty($edi_nome)) {
        echo "error"; // Mensagem de erro se o campo estiver vazio
        exit;
    }

    $query = "INSERT INTO editora (edi_nome) VALUES (:edi_nome)";

    try {
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':edi_nome', $edi_nome, PDO::PARAM_STR);
        $stmt->execute();

        // Retornar o ID da nova editora cadastrada
        echo $pdo->lastInsertId(); // Envia o ID gerado para o cliente
    } catch (PDOException $e) {
        // Registrar o erro no log para depuração (opcional)
        file_put_contents('log_error.txt', $e->getMessage() . PHP_EOL, FILE_APPEND);

        echo "error"; // Mensagem em caso de erro
    }
}
