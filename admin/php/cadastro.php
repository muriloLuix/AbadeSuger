<?php

require '../../assets/php/info.php';

$cadastro_sucesso = false;  // Variável para controlar a exibição do modal de sucesso

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recebe os dados do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_BCRYPT); // Criptografa a senha

    // Insere no banco de dados
    $sql = "INSERT INTO admin (adm_nome, adm_email, adm_senha) VALUES (:nome, :email, :senha)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':senha', $senha);

    if ($stmt->execute()) {
        // Redireciona de volta para admin.php com parâmetro GET para indicar sucesso
        header("Location: ../admin.php?cadastro=sucesso");

        exit();
    } else {
        echo "Erro ao cadastrar usuário.";
    }
}
?>
