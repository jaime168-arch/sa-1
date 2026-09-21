<?php
session_start();

// Destrói todas as variáveis de sessão
$_SESSION = array();

// Destrói a sessão no servidor
session_destroy();

// Redireciona para o login
header("Location: login.php");
exit;
?>