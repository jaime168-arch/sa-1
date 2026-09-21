<?php
$host = 'localhost';
$dbname = 'ja_ismaga';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host={$host};dbname={$dbname};charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Exibe a mensagem de erro exata do MySQL na tela
    die("<strong>Erro de Conexão:</strong> " . $e->getMessage());
}
?>