<?php
// get_livro.php

include('../../assets/php/info.php'); // Conexão com o banco de dados

if (isset($_GET['id'])) {
    $livroId = $_GET['id'];

    // Validação do ID
    if (!is_numeric($livroId)) {
        echo json_encode(['error' => 'ID inválido']);
        exit;
    }

    try {
        // Buscar os dados do livro
        $sql = "SELECT * FROM livros WHERE liv_id = :livroId";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':livroId', $livroId, PDO::PARAM_INT);
        $stmt->execute();
        $livro = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$livro) {
            echo json_encode(['error' => 'Livro não encontrado']);
            exit;
        }

        // Buscar as categorias
        $sqlCategorias = "SELECT cat_id, cat_nome FROM categoria ORDER BY cat_nome ASC";
        $stmtCategorias = $pdo->query($sqlCategorias);
        $categorias = $stmtCategorias->fetchAll(PDO::FETCH_ASSOC);

        // Buscar as atividades
        $sqlAtividades = "SELECT atv_id, atv_desc FROM status ORDER BY atv_desc ASC";
        $stmtAtividades = $pdo->query($sqlAtividades);
        $atividades = $stmtAtividades->fetchAll(PDO::FETCH_ASSOC);

        // Retornar os dados do livro junto com as categorias e atividades
        echo json_encode([
            'livro' => $livro,
            'categorias' => $categorias,
            'atividades' => $atividades
        ]);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Erro ao buscar dados: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'ID do livro não fornecido']);
}
?>
