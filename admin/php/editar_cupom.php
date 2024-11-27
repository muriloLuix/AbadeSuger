<?php
include('../../assets/php/info.php'); // Certifique-se de que o caminho está correto

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Coletar dados do formulário
    $cupId = $_POST['cup_id'];
    $cupCodigo = $_POST['cup_codigo'];
    $cupDesconto = $_POST['cup_desconto'];
    $cupDtValidade = $_POST['cup_dtvalidade'];

    // Query para atualizar o cupom
    $query = "UPDATE cupom SET cup_codigo = ?, cup_desconto = ?, cup_dtvalidade = ? WHERE cup_id = ?";
    
    try {
        $stmt = $pdo->prepare($query);
        $stmt->execute([$cupCodigo, $cupDesconto, $cupDtValidade, $cupId]);

        // Consulta para retornar a lista de cupons atualizada
        $query = "SELECT cup_id, cup_codigo, cup_desconto, cup_dtvalidade FROM cupom";
        $stmt = $pdo->prepare($query);
        $stmt->execute();

        // Exibir os resultados atualizados para o AJAX
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['cup_codigo']) . "</td>";
            echo "<td>" . htmlspecialchars($row['cup_desconto']) . "%</td>";
            echo "<td>" . htmlspecialchars($row['cup_dtvalidade']) . "</td>";
            echo "<td>
            <button class='btn-editar-cupom' data-id='" . $row['cup_id'] . "' data-codigo='" . $row['cup_codigo'] . "' data-desconto='" . $row['cup_desconto'] . "' data-validade='" . $row['cup_dtvalidade'] . "'>Editar</button>
            </td>";
            echo "</tr>";
        }
    } catch (PDOException $e) {
        echo "Erro ao atualizar o cupom: " . $e->getMessage();
    }
}
?>
