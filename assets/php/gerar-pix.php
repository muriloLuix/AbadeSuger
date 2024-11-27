<?php


session_start(); // Certifique-se de que isso está no topo do arquivo

require '../../vendor/autoload.php';

use Gerencianet\Gerencianet;

// Carrega as configurações
$options = require '../php/config-pix.php';

// Valor dinâmico do subtotal vindo do formulário
$data = json_decode(file_get_contents('php://input'), true);
$valorSubtotal = filter_var($data['subtotal'] ?? 0, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);


// Configurar a cobrança
$body = [
    'calendario' => [
        'expiracao' => 3600, // Expira em 1 hora
    ],
    'valor' => [
        'original' => number_format((float) $valorSubtotal, 2, '.', ''),
        // Formato correto
    ],
    'chave' => 'f0d6bf95-1e2a-40a6-be67-2c4de2a26aef', // Chave Pix cadastrada
    'solicitacaoPagador' => 'Identificação do pagamento',
];

try {
    $api = new Gerencianet($options);
    $pix = $api->pixCreateImmediateCharge([], $body);

    // Obter o QR Code
    $qrcode = $api->pixGenerateQRCode(['id' => $pix['loc']['id']]);

    // Armazena os dados na sessão
    $_SESSION['qrcode'] = $qrcode['qrcode'];
    $_SESSION['imagemQrcode'] = $qrcode['imagemQrcode'];
    $_SESSION['valorPagamento'] = number_format((float) $valorSubtotal, 2, ',', '.'); // Formata para o padrão brasileiro
    // Adicione o nome do recebedor à sessão
    $_SESSION['nomeRecebedor'] = 'Abade Suger Livraria'; // Nome do recebedor



    // Redireciona para a página do QR Code
    echo json_encode(['redirect' => '../html/exibir-qrcode.php']);
} catch (Exception $e) {
    // Registrar o erro no log do PHP
    error_log("Erro ao gerar Pix: " . $e->getMessage());
    error_log("Stack trace: " . $e->getTraceAsString());

    // Retornar o erro em formato JSON
    echo json_encode(['erro' => $e->getMessage()]);
}
