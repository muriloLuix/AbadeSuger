<?php
include('../../assets/php/info.php'); // Certifique-se de que o caminho está correto

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $edi_id = $_POST['edi_id'] ?? null; // Altere para edi_id
    $edi_nome = $_POST['edi_nome'] ?? ''; // Altere para edi_nome

    if (empty($edi_id) || empty($edi_nome)) {
        echo "error"; // Se algum valor estiver vazio, retorna erro
        exit;
    }

    $query = "UPDATE editora SET edi_nome = :edi_nome WHERE edi_id = :edi_id"; // Alterado de categoria para editora

    try {
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':edi_id', $edi_id, PDO::PARAM_INT); // Alterado para edi_id
        $stmt->bindParam(':edi_nome', $edi_nome);
        $stmt->execute();
        
        echo "success"; // Se a execução for bem-sucedida
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage(); // Exibe a mensagem de erro do banco de dados
    }
}
?>
