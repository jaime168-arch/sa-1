<?php
// Exibe erros em tela para evitar página em branco durante testes
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inicia a sessão com segurança
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$host    = "localhost";
$usuario = "root";
$senha   = "";
$banco   = "ja_ismaga";

// Evita crash total silencioso do PHP no MySQLi
mysqli_report(MYSQLI_REPORT_OFF);

// Conexão MySQLi Nativa
$conn = @new mysqli($host, $usuario, $senha, $banco);

// Validação de erro de conexão
if ($conn->connect_error) {
    die("<div style='font-family:sans-serif; padding:20px; color:red;'>
            <h3>Erro de Conexão com o Banco de Dados</h3>
            <p>" . $conn->connect_error . "</p>
         </div>");
}

// Define codificação de caracteres
$conn->set_charset("utf8mb4");

// Apelido para garantir que código que chama $pdo receba $conn sem dar erro
$pdo = $conn;
?>