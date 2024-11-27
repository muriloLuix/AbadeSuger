<?php
session_start();
require 'info.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['userId']) && isset($data['livroId']) && isset($data['action'])) {
        $userId = $data['userId'];
        $livroId = $data['livroId'];
        $action = $data['action'];

        // Verificar se o usuário está logado
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['status' => 'error', 'message' => 'Usuário não está logado.']);
            exit;
        }

        // Debugging: Verifique os valores que estão sendo passados
        error_log("User ID: $userId, Livro ID: $livroId, Action: $action");

        if ($action === 'add') {
            // Adicionar favorito
            try {
                $query = "INSERT INTO favorito (cli_id, liv_id, fav_dtfavorito) VALUES (:userId, :livroId, NOW())";
                $stmt = $pdo->prepare($query);
                $stmt->execute(['userId' => $userId, 'livroId' => $livroId]);

                // Verifique se a inserção foi bem-sucedida
                if ($stmt->rowCount() > 0) {
                    error_log("Favorito adicionado com sucesso!");
                } else {
                    error_log("Falha ao adicionar favorito.");
                }

                // Contagem de favoritos
                $query = "SELECT COUNT(*) as favoritosCount FROM favorito WHERE cli_id = :userId";
                $stmt = $pdo->prepare($query);
                $stmt->execute(['userId' => $userId]);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                echo json_encode([
                    'status' => 'success',
                    'favoritosCount' => $result['favoritosCount']
                ]);
            } catch (PDOException $e) {
                // Captura erros de banco de dados
                echo json_encode(['status' => 'error', 'message' => 'Erro ao adicionar favorito: ' . $e->getMessage()]);
            }
        } elseif ($action === 'remove') {
            // Remover favorito
            try {
                $query = "DELETE FROM favorito WHERE cli_id = :userId AND liv_id = :livroId";
                $stmt = $pdo->prepare($query);
                $stmt->execute(['userId' => $userId, 'livroId' => $livroId]);

                // Contagem de favoritos
                $query = "SELECT COUNT(*) as favoritosCount FROM favorito WHERE cli_id = :userId";
                $stmt = $pdo->prepare($query);
                $stmt->execute(['userId' => $userId]);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                echo json_encode([
                    'status' => 'success',
                    'favoritosCount' => $result['favoritosCount']
                ]);
            } catch (PDOException $e) {
                echo json_encode(['status' => 'error', 'message' => 'Erro ao remover favorito: ' . $e->getMessage()]);
            }
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Dados inválidos']);
    }
}
?>
