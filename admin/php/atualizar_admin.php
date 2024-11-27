<?php
require '../../assets/php/info.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $admin_id = $_SESSION['adm_id'];

    if (!empty($nome) && !empty($email)) {
        $sql = "UPDATE admin SET adm_nome = :nome, adm_email = :email WHERE adm_id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':id', $admin_id);

        if ($stmt->execute()) {
            // Atualiza as informações na sessão
            $_SESSION['adm_nome'] = $nome;
            $_SESSION['adm_email'] = $email;

            echo "Informações atualizadas com sucesso!";
        } else {
            echo "Erro ao atualizar informações.";
        }
    } else {
        echo "Todos os campos são obrigatórios.";
    }
} else {
    echo "Método inválido.";
}
?>