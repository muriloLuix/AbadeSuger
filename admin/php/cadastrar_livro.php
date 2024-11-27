<?php
include('../../assets/php/info.php'); // Conexão com o banco

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Captura os valores do formulário (não inclua o liv_id)
    $aut_id = $_POST['aut_id'];
    $edi_id = $_POST['edi_id'];
    $cat_id = $_POST['cat_id'];
    $atv_id = $_POST['atv_id'];
    $liv_idioma = $_POST['liv_idioma'];
    $liv_titulo = $_POST['liv_titulo'];
    $liv_dtpublicacao = $_POST['liv_dtpublicacao'];
    $liv_preco = $_POST['liv_preco'];
    $liv_estoque = $_POST['liv_estoque'];
    $liv_desc = nl2br($_POST['liv_desc']);
    $liv_adicional = nl2br($_POST['liv_adicional']);
    $liv_pag = $_POST['liv_pag'];

    // Processamento do upload da imagem
    $liv_img = '';
    if (isset($_FILES['liv_img']) && $_FILES['liv_img']['error'] === UPLOAD_ERR_OK) {
        $imagemTemp = $_FILES['liv_img']['tmp_name'];
        $extensao = pathinfo($_FILES['liv_img']['name'], PATHINFO_EXTENSION);
        $imagemNomeSeguro = uniqid('livro_', true) . '.' . $extensao;
        $caminhoImagem = '../../assets/img/capalivro/' . $imagemNomeSeguro;

        if (move_uploaded_file($imagemTemp, $caminhoImagem)) {
            $liv_img = $caminhoImagem;
        } else {
            echo "Erro ao fazer o upload da imagem.";
            exit();
        }
    }

    // Insere os dados no banco
    $query = "INSERT INTO LIVROS (
        aut_id, edi_id, cat_id, atv_id, liv_idioma, liv_titulo, liv_dtpublicacao, liv_preco, liv_estoque, liv_desc, liv_pag, liv_img, liv_adicional
    ) VALUES (
        :aut_id, :edi_id, :cat_id, :atv_id, :liv_idioma, :liv_titulo, :liv_dtpublicacao, :liv_preco, :liv_estoque, :liv_desc, :liv_pag, :liv_img, :liv_adicional
    )";

    $stmt = $pdo->prepare($query);

    $stmt->bindParam(':aut_id', $aut_id);
    $stmt->bindParam(':edi_id', $edi_id);
    $stmt->bindParam(':cat_id', $cat_id);
    $stmt->bindParam(':atv_id', $atv_id);
    $stmt->bindParam(':liv_idioma', $liv_idioma);
    $stmt->bindParam(':liv_titulo', $liv_titulo);
    $stmt->bindParam(':liv_dtpublicacao', $liv_dtpublicacao);
    $stmt->bindParam(':liv_preco', $liv_preco);
    $stmt->bindParam(':liv_estoque', $liv_estoque);
    $stmt->bindParam(':liv_desc', $liv_desc);
    $stmt->bindParam(':liv_pag', $liv_pag);
    $stmt->bindParam(':liv_img', $liv_img);
    $stmt->bindParam(':liv_adicional', $liv_adicional);

    // Executa a query e retorna a resposta
    if ($stmt->execute()) {
        echo "Livro cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar o livro.";
    }
}
?>