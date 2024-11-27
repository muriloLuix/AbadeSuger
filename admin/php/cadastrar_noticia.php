<?php
include('../../assets/php/info.php'); // Inclua a conexão com o banco

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $not_titulo = $_POST['not_titulo'];
    $not_resumo = $_POST['not_resumo'];
    $not_desc = $_POST['not_desc'];
    $not_resp = $_POST['not_resp'];
    $not_dtcriacao = $_POST['not_dtcriacao'];
    $not_prioridade = isset($_POST['not_prioridade']) ? 1 : 0; // Define como 1 se marcado, senão 0

    // Upload de imagem
    if (isset($_FILES['not_img']) && $_FILES['not_img']['error'] === UPLOAD_ERR_OK) {
        $img_name = $_FILES['not_img']['name'];
        $img_tmp = $_FILES['not_img']['tmp_name'];
        $img_dir = '../../assets/img/noticiasImg/' . basename($img_name);

        if (move_uploaded_file($img_tmp, $img_dir)) {
            $not_img = $img_dir;
        } else {
            echo 'Erro ao fazer upload da imagem.';
            exit;
        }
    } else {
        echo 'Imagem não foi enviada.';
        exit;
    }

    try {
        $query = "INSERT INTO noticias (not_titulo, not_resumo, not_desc, not_resp, not_dtcriacao, not_img, not_prioridade) 
                  VALUES (:not_titulo, :not_resumo, :not_desc, :not_resp, :not_dtcriacao, :not_img, :not_prioridade)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':not_titulo', $not_titulo);
        $stmt->bindParam(':not_resumo', $not_resumo);
        $stmt->bindParam(':not_desc', $not_desc);
        $stmt->bindParam(':not_resp', $not_resp);
        $stmt->bindParam(':not_dtcriacao', $not_dtcriacao);
        $stmt->bindParam(':not_img', $not_img);
        $stmt->bindParam(':not_prioridade', $not_prioridade, PDO::PARAM_BOOL);
        $stmt->execute();

        echo 'success';
    } catch (PDOException $e) {
        echo 'Erro: ' . $e->getMessage();
    }
}
?>