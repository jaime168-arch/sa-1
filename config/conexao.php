<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$host    = "localhost";
$usuario = "root";
$senha   = "";
$banco   = "ja_ismaga";

mysqli_report(MYSQLI_REPORT_OFF);

$conn = @new mysqli($host, $usuario, $senha, $banco);

if ($conn->connect_error) {
    die("<div style='font-family:sans-serif; padding:20px; color:red;'>
            <h3>Erro de Conexão com o Banco de Dados</h3>
            <p>" . $conn->connect_error . "</p>
         </div>");
}

$conn->set_charset("utf8mb4");