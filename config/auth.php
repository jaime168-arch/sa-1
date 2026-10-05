<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function verificarAutenticacao() {
    if (!isset($_SESSION['usuario_id']) || empty($_SESSION['logged_in'])) {
        $_SESSION['mensagem_erro'] = "Acesso negado. Faça login para acessar esta página.";
        header("Location: login.php");
        exit;
    }
}

function verificarPermissaoAdmin() {
    verificarAutenticacao(); 

    if (($_SESSION['usuario_tipo'] ?? '') !== 'admin') {
        $_SESSION['mensagem_erro'] = "Acesso negado: Você não possui permissão de Administrador para acessar esta área.";
        header("Location: home.php"); 
        exit;
    }
}