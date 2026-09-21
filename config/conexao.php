<?php
$host = 'localhost';
$dbname = 'ja_ismaga'; // Deve corresponder ao nome no script SQL
$username = 'root';    // Utilizador padrão do XAMPP
$password = '';        // A password padrão do XAMPP é vazia

try {
    $pdo = new PDO("mysql:host={$host};dbname={$dbname};charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Exibe a mensagem de erro que aparece na sua imagem
    die("Desculpe, ocorreu um problema ao conectar com o banco de dados. Verifique se o MySQL está ativo no XAMPP.");
}
?>