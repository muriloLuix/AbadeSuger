<?php
include('../../assets/php/info.php'); // Inclua a conexão com o banco

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cup_codigo = $_POST['cup_codigo'];
    $cup_desconto = $_POST['cup_desconto'];
    $cup_dtvalidade = $_POST['cup_dtvalidade'];

    try {
        $query = "INSERT INTO cupom (cup_codigo, cup_desconto, cup_dtvalidade) VALUES (:cup_codigo, :cup_desconto, :cup_dtvalidade)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':cup_codigo', $cup_codigo);
        $stmt->bindParam(':cup_desconto', $cup_desconto);
        $stmt->bindParam(':cup_dtvalidade', $cup_dtvalidade);
        $stmt->execute();

        echo 'success';
    } catch (PDOException $e) {
        echo 'Erro: ' . $e->getMessage();
    }
}
?>
