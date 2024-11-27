<?php
// Conexão com o banco de dados
include 'info.php';

$data = json_decode(file_get_contents('php://input'), true);
$cupom = $data['cupom'];
$compra_id = $data['compra_id'];  // ID da compra

// Consultar o cupom no banco
$sql = "SELECT cup_codigo, cup_desconto, cup_dtvalidade FROM cupom WHERE cup_codigo = :cupom";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':cupom', $cupom);
$stmt->execute();

$cupomData = $stmt->fetch(PDO::FETCH_ASSOC);

if ($cupomData) {
    // Verificar se o cupom ainda é válido
    $validade = new DateTime($cupomData['cup_dtvalidade']);
    $hoje = new DateTime();

    if ($hoje > $validade) {
        // Cupom expirado
        echo json_encode(['status' => 'erro']);
    } else {
        // Verificar se o cupom já foi aplicado na compra
        $sqlVerificar = "SELECT * FROM cupom_aplicado WHERE compra_id = :compra_id AND cup_codigo = :cupom";
        $stmtVerificar = $pdo->prepare($sqlVerificar);
        $stmtVerificar->bindParam(':compra_id', $compra_id);
        $stmtVerificar->bindParam(':cupom', $cupom);
        $stmtVerificar->execute();

        if ($stmtVerificar->rowCount() > 0) {
            // Cupom já foi aplicado nesta compra
            echo json_encode(['status' => 'erro']);
        } else {
            // O cupom é válido e ainda não foi aplicado nesta compra
            // Aplicar o cupom na compra
            $sqlAplicar = "INSERT INTO cupom_aplicado (compra_id, cup_codigo) VALUES (:compra_id, :cupom)";
            $stmtAplicar = $pdo->prepare($sqlAplicar);
            $stmtAplicar->bindParam(':compra_id', $compra_id);
            $stmtAplicar->bindParam(':cupom', $cupom);
            $stmtAplicar->execute();

            // Retornar o desconto
            echo json_encode([
                'status' => 'sucesso',
                'desconto' => $cupomData['cup_desconto']
            ]);
        }
    }
} else {
    // Cupom não encontrado
    echo json_encode(['status' => 'erro']);
}
?>
