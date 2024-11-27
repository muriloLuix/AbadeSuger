<?php
include('../../assets/php/info.php'); // Conexão com o banco de dados

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['liv_id'])) {
    $livroId = $_POST['liv_id'];

    try {
        // Iniciar uma transação para garantir consistência
        $pdo->beginTransaction();

        // Excluir o livro do carrinho (ou qualquer tabela relacionada)
        $queryCarrinho = "DELETE FROM carrinho WHERE liv_id = :liv_id";
        $stmtCarrinho = $pdo->prepare($queryCarrinho);
        $stmtCarrinho->execute([':liv_id' => $livroId]);

        // Excluir o livro da tabela livros
        $queryLivros = "DELETE FROM livros WHERE liv_id = :liv_id";
        $stmtLivros = $pdo->prepare($queryLivros);
        $stmtLivros->execute([':liv_id' => $livroId]);

        // Commit para confirmar as alterações no banco de dados
        $pdo->commit();

        // Retorna sucesso como resposta JSON
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        // Rollback em caso de erro
        $pdo->rollBack();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'ID do livro não encontrado.']);
}
?>