<?php
session_start();
require_once __DIR__ . '/../config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = trim($_POST['senha'] ?? '');

    if (empty($email) || empty($senha)) {$_SESSION['mensagem_erro'] = "Preencha todos os campos.";
        header("Location: login.php");
        exit;
    }

    try {
        // Procura o utilizador pelo e-mail
        $stmt =$pdo->prepare("SELECT * FROM usuarios WHERE email = :email LIMIT 1");
        $stmt->execute([':email' =>$email]);
        $usuario =$stmt->fetch(PDO::FETCH_ASSOC);

        // Verifica se o utilizador existe e se a senha corresponde (suporta BCRYPT e texto limpo para transição)
        if ($usuario && (password_verify($senha,$usuario['senha']) || $senha ===$usuario['senha'])) {
            
            // Regista os dados essenciais na sessão
            $_SESSION['usuario_id']   =$usuario['id'];
            $_SESSION['usuario_nome'] =$usuario['nome'];
            $_SESSION['usuario_tipo'] =$usuario['tipo'];

            // Se a senha ainda estava em texto limpo, converte automaticamente para hash BCRYPT
            if ($senha ===$usuario['senha']) {
                $novoHash = password_hash($senha, PASSWORD_BCRYPT);
                $upStmt =$pdo->prepare("UPDATE usuarios SET senha = :senha WHERE id = :id");
                $upStmt->execute([':senha' => $novoHash, ':id' =>$usuario['id']]);
            }

            header("Location: home.php");
            exit;
        } else {
            $_SESSION['mensagem_erro'] = "E-mail ou senha incorretos.";
            header("Location: login.php");
            exit;
        }

    } catch (PDOException $e) {
        error_log("Erro no login: " . $e->getMessage());$_SESSION['mensagem_erro'] = "Erro ao processar o login.";
        header("Location: login.php");
        exit;
    }
} else {
    header("Location: login.php");
    exit;
}