<?php
include('../../assets/php/info.php'); // Certifique-se de que o caminho está correto

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cat_nome = $_POST['cat_nome'];

    // Inserir categoria no banco de dados
    $query = "INSERT INTO categoria (cat_nome) VALUES (:cat_nome)";
    try {
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':cat_nome', $cat_nome);
        $stmt->execute();

        // Se o cadastro for bem-sucedido, retorna "success"
        echo "success";
    } catch (PDOException $e) {
        echo "Erro ao cadastrar a categoria: " . $e->getMessage();
    }
}
?>
