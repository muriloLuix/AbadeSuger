<?php
include('../../assets/php/info.php'); // Conexão com o banco de dados

// Consulta para selecionar todos os cupons
$query = "SELECT cup_id, cup_codigo, cup_desconto, cup_dtvalidade FROM cupom";

try {
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    // Exibir os resultados da tabela
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['cup_codigo']) . "</td>";
        echo "<td>" . htmlspecialchars($row['cup_desconto']) . "%</td>";
        echo "<td>" . htmlspecialchars($row['cup_dtvalidade']) . "</td>";
        echo "<td>
                <button class='btn-editar-cupom' data-id='" . htmlspecialchars($row['cup_id']) . "' 
                data-codigo='" . htmlspecialchars($row['cup_codigo']) . "' 
                data-desconto='" . htmlspecialchars($row['cup_desconto']) . "' 
                data-validade='" . htmlspecialchars($row['cup_dtvalidade']) . "'>Editar</button>
                <button class='btn-excluir-cupom' data-id='" . htmlspecialchars($row['cup_id']) . "'>Excluir</button>
              </td>";
        echo "</tr>";
    }
} catch (PDOException $e) {
    echo "Erro na consulta: " . $e->getMessage();
}
?>