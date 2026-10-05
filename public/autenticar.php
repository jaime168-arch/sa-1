<?php
session_start();
require_once __DIR__ . '/../config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = strtolower(trim($_POST['email'] ?? ''));
    $senha = $_POST['senha'] ?? '';

    if (empty($email) || empty($senha)) {
        $_SESSION['mensagem_erro'] = "Preencha o e-mail e a senha para entrar.";
        header("Location: login.php");
        exit;
    }

    try {
        // Busca o usuário no banco de dados
        $stmt = $pdo->prepare("SELECT id, nome, email, senha, tipo, ativo FROM usuarios WHERE LOWER(email) = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        $usuario = $stmt->fetch();

        // 1. Verifica se o usuário existe
        if (!$usuario) {
            $_SESSION['mensagem_erro'] = "E-mail ou senha incorretos.";
            header("Location: login.php");
            exit;
        }

        // 2. Verifica se a conta está ativa
        if ((int)$usuario['ativo'] !== 1) {
            $_SESSION['mensagem_erro'] = "A sua conta está inativa. Contacte o administrador.";
            header("Location: login.php");
            exit;
        }

        // 3. Verificação Segura da Senha Hash (password_verify)
        if (password_verify($senha, $usuario['senha'])) {
            
            // Previne Session Fixation Attack regenerando o ID da sessão
            session_regenerate_id(true);

            // Armazena na sessão os dados obrigatórios do Requisito
            $_SESSION['usuario_id']   = (int)$usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            $_SESSION['usuario_tipo'] = strtolower($usuario['tipo']); // 'admin' ou 'operador'
            $_SESSION['logged_in']    = true;

            $_SESSION['mensagem_sucesso'] = "Bem-vindo de volta, " . htmlspecialchars($usuario['nome']) . "!";
            
            // Redireciona para o painel principal
            header("Location: home.php");
            exit;

        } else {
            $_SESSION['mensagem_erro'] = "E-mail ou senha incorretos.";
            header("Location: login.php");
            exit;
        }

    } catch (PDOException $e) {
        error_log("Erro de Autenticação: " . $e->getMessage());
        $_SESSION['mensagem_erro'] = "Erro interno ao processar o login. Tente novamente.";
        header("Location: login.php");
        exit;
    }

} else {
    header("Location: login.php");
    exit;
}