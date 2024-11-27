<?php
include('info.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['status' => 'error', 'message' => 'ID do usuário não encontrado na sessão.']);
        exit;
    }

    $user_id = $_SESSION['user_id'];

    $dados = [
        'cli_nome' => $_POST['cli_nome'],
        'cli_sobrenome' => $_POST['cli_sobrenome'],
        'cli_email' => $_POST['cli_email'],
        'cli_telefone' => $_POST['cli_telefone'],
        'cli_dtnasc' => $_POST['cli_dtnasc'],
        'cli_cep' => $_POST['cli_cep'],
        'cli_rua' => $_POST['cli_rua'],
        'cli_numero' => $_POST['cli_numero'],
        'cli_complemento' => $_POST['cli_complemento'],
        'cli_bairro' => $_POST['cli_bairro'],
        'cli_cidade' => $_POST['cli_cidade'],
        'cli_cpf' => $_POST['cli_cpf']
    ];

    $sql = "UPDATE clientes SET 
                cli_nome = :cli_nome, 
                cli_sobrenome = :cli_sobrenome, 
                cli_email = :cli_email, 
                cli_telefone = :cli_telefone, 
                cli_dtnasc = :cli_dtnasc, 
                cli_cep = :cli_cep, 
                cli_rua = :cli_rua, 
                cli_numero = :cli_numero, 
                cli_complemento = :cli_complemento, 
                cli_bairro = :cli_bairro, 
                cli_cidade = :cli_cidade, 
                cli_cpf = :cli_cpf 
            WHERE cli_id = :user_id";

    $dados['user_id'] = $user_id;

    $stmt = $pdo->prepare($sql);

    if ($stmt->execute($dados)) {
        echo json_encode(['status' => 'success', 'message' => 'Informações atualizadas com sucesso!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Erro ao atualizar as informações.']);
    }
}
?>