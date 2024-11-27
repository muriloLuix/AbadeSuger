<?php
session_start();

// Configurar headers para JSON
header('Content-Type: application/json');

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'erro', 'message' => 'Usuário não logado.']);
    exit;
}

// Inclui o arquivo de conexão com o banco
include 'info.php';

// Lê os dados enviados como JSON
$data = json_decode(file_get_contents('php://input'), true);

$livId = $data['liv_id'] ?? null;

if (empty($livId)) {
    echo json_encode(['status' => 'erro', 'message' => 'ID do livro não informado.']);
    exit;
}

// Depuração: Verificar valores recebidos
error_log("Livro ID recebido: " . $livId);
error_log("Cliente ID: " . $_SESSION['user_id']);

try {
    // Prepara e executa a exclusão
    $sql = "DELETE FROM carrinho WHERE liv_id = :liv_id AND cli_id = :cli_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':liv_id', $livId, PDO::PARAM_INT);
    $stmt->bindParam(':cli_id', $_SESSION['user_id'], PDO::PARAM_INT);

    if ($stmt->execute()) {
        // Depuração: Verificar se algo foi excluído
        if ($stmt->rowCount() > 0) {
            echo json_encode(['status' => 'sucesso', 'message' => 'Produto removido com sucesso.']);
        } else {
            echo json_encode(['status' => 'erro', 'message' => 'Nenhuma linha foi excluída.']);
        }
    } else {
        echo json_encode(['status' => 'erro', 'message' => 'Erro ao executar a exclusão.']);
    }
} catch (Exception $e) {
    // Captura erros e retorna como JSON
    echo json_encode(['status' => 'erro', 'message' => $e->getMessage()]);
}
