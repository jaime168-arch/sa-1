<?php
session_start();
require_once __DIR__ . '/../config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $email = strtolower(trim($_POST['email'] ?? ''));
    $senha = $_POST['senha'] ?? '';

    if (empty($email) || empty($senha)) {
        $_SESSION['mensagem_erro'] = "Preencha todos os campos.";
        header("Location: login.php");
        exit;
    }

    try {
        // Busca o usuário ignorando diferença entre maiúsculas e minúsculas no e-mail
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE LOWER(email) = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            // Verifica se a conta está ativa
            if (isset($usuario['ativo']) && $usuario['ativo'] == 0) {
                $_SESSION['mensagem_erro'] = "Esta conta está inativa. Contacte o administrador.";
                header("Location: login.php");
                exit;
            }

            // Verifica a senha criptografada
            if (password_verify($senha, $usuario['senha'])) {
                // Guarda dados na sessão
                $_SESSION['usuario_id']   = $usuario['id'];
                $_SESSION['usuario_nome'] = $usuario['nome'];
                $_SESSION['usuario_tipo'] = $usuario['tipo'] ?? 'operador';

                header("Location: home.php");
                exit;
            } else {
                $_SESSION['mensagem_erro'] = "Senha incorreta.";
                header("Location: login.php");
                exit;
            }
        } else {
            $_SESSION['mensagem_erro'] = "E-mail não encontrado.";
            header("Location: login.php");
            exit;
        }

    } catch (PDOException $e) {
        $_SESSION['mensagem_erro'] = "Erro de conexão: " . $e->getMessage();
        header("Location: login.php");
        exit;
    }

} else {
    header("Location: login.php");
    exit;
}