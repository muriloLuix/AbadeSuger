<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=abade', 'root', 'Murylindos1204*');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if ($pdo) {
        echo "";
    }
} catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
}

?>