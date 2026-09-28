<?php
session_start();
require_once __DIR__ . '/../config/conexao.php';

$paginaLogin = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = strtolower(trim($_POST['email'] ?? ''));
    $senha = trim($_POST['senha'] ?? '');

    if (empty($email) || empty($senha)) {
        $_SESSION['mensagem_erro'] = "Preencha o e-mail e a senha.";
        header("Location: " . $paginaLogin);
        exit;
    }

    try {
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE LOWER(email) = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            
            if (isset($usuario['ativo']) && (int)$usuario['ativo'] === 0) {
                $_SESSION['mensagem_erro'] = "A sua conta está inativa. Contacte o administrador.";
                header("Location: " . $paginaLogin);
                exit;
            }

            if (password_verify($senha, $usuario['senha']) || $senha === $usuario['senha']) {
                $_SESSION['usuario_id']   = $usuario['id'];
                $_SESSION['usuario_nome'] = $usuario['nome'];
                $_SESSION['usuario_tipo'] = $usuario['tipo'] ?? 'operador';

                header("Location: home.php");
                exit;
            } else {
                $_SESSION['mensagem_erro'] = "Senha incorreta.";
                header("Location: " . $paginaLogin);
                exit;
            }

        } else {
            $_SESSION['mensagem_erro'] = "O e-mail '$email' não foi encontrado na base de dados.";
            header("Location: " . $paginaLogin);
            exit;
        }

    } catch (PDOException $e) {
        $_SESSION['mensagem_erro'] = "Erro de conexão: " . $e->getMessage();
        header("Location: " . $paginaLogin);
        exit;
    }

} else {
    header("Location: " . $paginaLogin);
    exit;
}