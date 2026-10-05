<?php
session_start();
require_once __DIR__ . '/../config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = strtolower(trim($_POST['email'] ?? ''));
    $senha = trim($_POST['senha'] ?? '');

    if (empty($email) || empty($senha)) {
        $_SESSION['mensagem_erro'] = "Preencha todos os campos.";
        header("Location: login.php");
        exit;
    }

    try {
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE LOWER(email) = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        // Aceita a senha tanto por hash (BCRYPT) quanto em texto limpo caso ainda esteja em transicao
        if ($usuario && (password_verify($senha, $usuario['senha']) || $senha === $usuario['senha'])) {
            
            session_regenerate_id(true);
            $_SESSION['usuario_id']   = (int)$usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            $_SESSION['usuario_tipo'] = strtolower($usuario['tipo']);
            $_SESSION['logged_in']    = true;

            // Se a senha no banco ainda estava em texto puro, converte para BCRYPT automaticamente
            if ($senha === $usuario['senha']) {
                $novoHash = password_hash($senha, PASSWORD_DEFAULT);
                $up = $pdo->prepare("UPDATE usuarios SET senha = :senha WHERE id = :id");
                $up->execute([':senha' => $novoHash, ':id' => $usuario['id']]);
            }

            header("Location: home.php");
            exit;
        } else {
            $_SESSION['mensagem_erro'] = "E-mail ou senha incorretos.";
            header("Location: login.php");
            exit;
        }

    } catch (PDOException $e) {
        $_SESSION['mensagem_erro'] = "Erro ao processar o login.";
        header("Location: login.php");
        exit;
    }
} else {
    header("Location: login.php");
    exit;
}