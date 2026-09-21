<?php
session_start();

// Limpa todas as variáveis da sessão atual
$_SESSION = array();

// Se for utilizado cookie de sessão, elimina o cookie no navegador do utilizador
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Destrói completamente a sessão
session_destroy();

// Inicia uma nova sessão apenas para mandar a mensagem de confirmação
session_start();
$_SESSION['mensagem_sucesso'] = "Sessão encerrada com sucesso!";

// Redireciona para a página de login
header('Location: login.php');
exit();