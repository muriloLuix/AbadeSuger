<?php
try {
    $pdo = new PDO('pgsql:host=localhost;port=5432;dbname=abade', 'postgres', 'Murylindos1204*');
    if ($pdo) {
        echo "";
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}