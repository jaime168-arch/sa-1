<?php
/**
 * Configuração de Conexão com o Banco de Dados MySQL (Projeto Ferrorama - SENAI)
 */

// Parâmetros de conexão do ambiente XAMPP / Localhost
$host     = 'localhost';
$dbname   = 'ja_ismaga'; // Nome do banco de dados configurado no SA.sql
$username = 'root';      // Usuário padrão do XAMPP
$password = '';          // Senha padrão do XAMPP (vazia)

try {
    // Instancia a conexão PDO
    $pdo = new PDO("mysql:host={$host};dbname={$dbname};charset=utf8mb4", $username, $password);

    // Configura o PDO para lançar exceções em caso de erros de SQL
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Define o modo de busca padrão para array associativo (ex: $linha['nome'])
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Em ambiente de produção/apresentação, logamos o erro e exibimos uma mensagem amigável
    // Descomente a linha abaixo caso queira ver o erro detalhado durante o desenvolvimento:
    // die("Erro de Conexão com o Banco de Dados: " . $e->getMessage());

    die("Desculpe, ocorreu um problema ao conectar com o banco de dados. Verifique se o MySQL está ativo no XAMPP.");
}