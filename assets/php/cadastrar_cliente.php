<?php
// Inclui a conexão com o banco de dados
include('info.php');

// Função para gerar o login
function gerarLogin($nomeCompleto)
{
    $nomeCompleto = strtolower(trim($nomeCompleto));
    $nomeParts = explode(" ", $nomeCompleto);
    $primeiroNome = $nomeParts[0];
    $sobrenomes = array_slice($nomeParts, 1);
    $login = $primeiroNome . '.' . implode('.', $sobrenomes);
    return $login;
}

if (
    isset($_POST['cli_nome']) && isset($_POST['cli_sobrenome']) &&
    isset($_POST['cli_telefone']) && isset($_POST['cli_dtnasc']) &&
    isset($_POST['cli_email']) && isset($_POST['cli_cep']) &&
    isset($_POST['cli_rua']) && isset($_POST['cli_bairro']) &&
    isset($_POST['cli_cidade']) && isset($_POST['cli_estado']) &&
    isset($_POST['cli_numero']) && isset($_POST['cli_senha']) &&
    isset($_POST['gen_id']) && isset($_POST['cli_cpf'])
) {
    $nome = $_POST['cli_nome'];
    $sobrenome = $_POST['cli_sobrenome'];
    $telefone = $_POST['cli_telefone'];

    // Convertendo a data para o formato 'YYYY-MM-DD'
    $dtnasc = $_POST['cli_dtnasc'];
    $date = DateTime::createFromFormat('d/m/Y', $dtnasc);
    if ($date) {
        $dtnasc = $date->format('Y-m-d');
    } else {
        echo "Data de nascimento inválida!";
        exit;
    }

    $email = $_POST['cli_email'];
    $cep = $_POST['cli_cep'];
    $rua = $_POST['cli_rua'];
    $bairro = $_POST['cli_bairro'];
    $cidade = $_POST['cli_cidade'];
    $estado = $_POST['cli_estado'];
    $numero = $_POST['cli_numero'];
    $complemento = $_POST['cli_complemento'] ?? '';
    $senha = password_hash($_POST['cli_senha'], PASSWORD_DEFAULT);
    $gen_id = $_POST['gen_id'];
    $cpf = $_POST['cli_cpf'];

    $login = gerarLogin($nome . ' ' . $sobrenome);

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM clientes WHERE cli_login = :cli_login");
    $stmt->execute([':cli_login' => $login]);
    $loginExistente = $stmt->fetchColumn();

    if ($loginExistente > 0) {
        $i = 1;
        while ($loginExistente > 0) {
            $novoLogin = $login . $i;
            $stmt->execute([':cli_login' => $novoLogin]);
            $loginExistente = $stmt->fetchColumn();
            $i++;
        }
        $login = $novoLogin;
    }

    $sql = "INSERT INTO clientes (cli_nome, cli_sobrenome, cli_telefone, cli_dtnasc, cli_email, cli_cep, cli_rua, cli_bairro, cli_cidade, cli_estado, cli_numero, cli_complemento, cli_senha, cli_login, gen_id, cli_cpf, cli_dtcadastro)
            VALUES (:nome, :sobrenome, :telefone, :dtnasc, :email, :cep, :rua, :bairro, :cidade, :estado, :numero, :complemento, :senha, :login, :gen_id, :cpf, NOW())";

    $stmt = $pdo->prepare($sql);

    if (
        $stmt->execute([
            ':nome' => $nome,
            ':sobrenome' => $sobrenome,
            ':telefone' => $telefone,
            ':dtnasc' => $dtnasc,
            ':email' => $email,
            ':cep' => $cep,
            ':rua' => $rua,
            ':bairro' => $bairro,
            ':cidade' => $cidade,
            ':estado' => $estado,
            ':numero' => $numero,
            ':complemento' => $complemento,
            ':senha' => $senha,
            ':login' => $login,
            ':gen_id' => $gen_id,
            ':cpf' => $cpf
        ])
    ) {
        // Retorna uma resposta de sucesso, que será capturada pelo AJAX
        echo "Cadastro realizado com sucesso!";
    } else {
        // Retorna uma mensagem de erro
        echo "Erro ao cadastrar. Tente novamente.";
    }
} else {
    // Caso algum campo esteja ausente
    echo "Por favor, preencha todos os campos obrigatórios.";
}
?>