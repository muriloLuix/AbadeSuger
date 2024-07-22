<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['attachmentWord']) && $_FILES['attachmentWord']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        $uploadFile = $uploadDir . basename($_FILES['attachmentWord']['name']);
        move_uploaded_file($_FILES['attachmentWord']['tmp_name'], $uploadFile);
    }

    if (isset($_FILES['attachmentImg']) && $_FILES['attachmentImg']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        $uploadFile = $uploadDir . basename($_FILES['attachmentImg']['name']);
        move_uploaded_file($_FILES['attachmentImg']['tmp_name'], $uploadFile);
    }

    // Aqui você pode processar os outros dados do formulário (form-bottom)
    // Exemplo: $_POST['name'], $_POST['email'], etc.

    echo "Formulário enviado com sucesso!";
} else {
    echo "Método de solicitação não permitido.";
}
?>