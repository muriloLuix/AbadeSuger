<?php
// editar_livro.php
include('../../assets/php/info.php'); // Conexão com o banco de dados

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Captura os dados enviados pelo formulário
    $livroId = $_POST['liv_id'];
    $catId = $_POST['cat_id'];
    $atvId = $_POST['atv_id'];
    $titulo = $_POST['liv_titulo'];
    $preco = $_POST['liv_preco'];
    $estoque = $_POST['liv_estoque'];
    $descricao = $_POST['liv_desc'];
    $adicional = $_POST['liv_adicional'];
    $paginas = $_POST['liv_pag'];

    try {
        // Atualizar o livro no banco de dados com os dados recebidos
        $query = "UPDATE livros SET
                    cat_id = :cat_id, 
                    atv_id = :atv_id,
                    liv_titulo = :liv_titulo,
                    liv_preco = :liv_preco,
                    liv_estoque = :liv_estoque,
                    liv_desc = :liv_desc,
                    liv_adicional = :liv_adicional,
                    liv_pag = :liv_pag
                  WHERE liv_id = :liv_id";

        $stmt = $pdo->prepare($query);
        $stmt->execute([
            ':liv_id' => $livroId,
            ':cat_id' => $catId,
            ':atv_id' => $atvId,
            ':liv_titulo' => $titulo,
            ':liv_preco' => $preco,
            ':liv_estoque' => $estoque,
            ':liv_desc' => $descricao,
            ':liv_adicional' => $adicional,
            ':liv_pag' => $paginas
        ]);

        // Retornar mensagem de sucesso
        echo "Livro atualizado com sucesso!";
    } catch (PDOException $e) {
        // Retornar mensagem de erro
        echo "Erro ao atualizar o livro: " . $e->getMessage();
    }
}
?>