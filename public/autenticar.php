<?php
session_start();

// Exibe erros na tela para descobrirmos se algo falhar no PHP
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../config/conexao.php'; // Ajuste o caminho para a conexao.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Captura os campos e remove espaços acidentais nas pontas
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $senha = isset($_POST['senha']) ? trim($_POST['senha']) : '';

    if (empty($email) || empty($senha)) {
        die("<strong>Erro:</strong> Por favor, preencha os campos de E-mail e Senha no formulário.");
    }

    try {
        // Busca o usuário ignorando maiúsculas/minúsculas no e-mail
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE LOWER(email) = LOWER(:email)");
        $stmt->execute([':email' => $email]);
        $usuario = $stmt->fetch();

        if (!$usuario) {
            die("<strong>Erro no Login:</strong> O e-mail <code>" . htmlspecialchars($email) . "</code> não foi encontrado na tabela 'usuarios'.");
        }

        // Teste 1: Comparação via password_verify (Hash)
        $senhaCorreta = password_verify($senha, $usuario['senha']);

        // Teste 2: Comparação em texto simples (Caso tenha sido salvo sem hash)
        if (!$senhaCorreta && $senha === $usuario['senha']) {
            $senhaCorreta = true;
        }

        if ($senhaCorreta) {
            // Login bem-sucedido! Salva na sessão e redireciona
            $_SESSION['usuario_id']   = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];

            header("Location: home.php");
            exit;
        } else {
            die("<strong>Erro no Login:</strong> A senha informada está incorreta para o utilizador <code>" . htmlspecialchars($email) . "</code>.");
        }

    } catch (PDOException $e) {
        die("Erro na consulta SQL: " . $e->getMessage());
    }
} else {
    // Se tentar acessar o arquivo via GET sem enviar o formulário
    header("Location: login.php");
    exit;
}