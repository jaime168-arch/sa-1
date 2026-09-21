<?php
session_start();
require_once __DIR__ . '/../config/conexao.php';

$email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
$senha = trim($_POST['senha'] ?? '');

if (!$email || empty($senha)) {
    $_SESSION['mensagem_erro'] = "Preencha todos os campos corretamente.";
    header("Location: login.php");
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
    $stmt->bindValue(':email', $email);
    $stmt->execute();
    $usuario = $stmt->fetch();

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        
        header("Location: home.php");
        exit;
    } else {
        $_SESSION['mensagem_erro'] = "E-mail ou senha inválidos.";
        header("Location: login.php");
        exit;
    }
} catch (PDOException $e) {
    $_SESSION['mensagem_erro'] = "Erro de autenticação: " . $e->getMessage();
    header("Location: login.php");
    exit;
}
?>