<?php
$host = '127.0.0.1';
$port = '3308'; // Porta exata exibida no painel do XAMPP
$dbname = 'ja_ismaga';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("<strong>Erro no MySQL:</strong> " . $e->getMessage());
}
?>