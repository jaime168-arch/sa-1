<?php
$host     = '127.0.0.1';
$port     = '3306'; 
$dbname   = 'ja_ismaga';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4", $username, $password);
    
    // Configura o PDO para disparar exceções em caso de erro no SQL
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Define o retorno dos dados como Array Associativo
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Grava o erro no log do servidor e encerra com mensagem tratada
    error_log("Erro de Conexão MySQL: " . $e->getMessage());
    die("Erro ao conectar com o banco de dados. Por favor, tente novamente mais tarde.");
}