<?php
include('../../assets/php/info.php'); // Certifique-se de que o caminho está correto

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $catId = $_POST['cat_id'] ?? null;
    $catNome = $_POST['cat_nome'] ?? null;

    // Debugging
    file_put_contents('debug_log.txt', "cat_id: $catId, cat_nome: $catNome\n", FILE_APPEND);

    if (!$catId || !$catNome) {
        echo 'error: Missing data'; // Retorno de erro para AJAX
        exit;
    }

    // Atualizar categoria no banco de dados
    $query = "UPDATE categoria SET cat_nome = :cat_nome WHERE cat_id = :cat_id";
    try {
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':cat_nome', $catNome);
        $stmt->bindParam(':cat_id', $catId);
        $stmt->execute();

        echo 'success'; // Retorno para AJAX
    } catch (PDOException $e) {
        echo 'error: ' . $e->getMessage(); // Retorno para AJAX em caso de erro
    }
}

?>
