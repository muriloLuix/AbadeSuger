<?php
include('../../assets/php/info.php'); // Conexão com o banco de dados

// Consulta para selecionar todos os autores
$query = "SELECT aut_id, aut_nome FROM autor";

try {
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    // Exibir os resultados da tabela
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['aut_nome']) . "</td>";
        echo "<td><a href='editar_autor.php?id=" . urlencode($row['aut_id']) . "'><button class='btn-editar-autor'>Editar</button></a></td>";
        echo "</tr>";
    }
} catch (PDOException $e) {
    echo "Erro na consulta: " . $e->getMessage();
}
?>
