<?php
session_start();

// Garante que o acesso a este arquivo ocorra exclusivamente via POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit();
}

// Inclui o arquivo de conexão com o banco de dados
require_once __DIR__ . '/../config/conexao.php';

// Captura e limpa os campos enviados pelo formulário
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$senha = filter_input(INPUT_POST, 'senha', FILTER_DEFAULT);

// Validação dos campos obrigatórios
if (!$email || empty($senha)) {
    $_SESSION['mensagem_erro'] = "Preencha o e-mail e a senha corretamente.";
    header('Location: login.php');
    exit();
}

try {
    // Consulta o usuário pelo e-mail
    $sql = $pdo->prepare("SELECT id, nome, email, senha FROM usuarios WHERE email = :email LIMIT 1");
    $sql->bindValue(':email', $email);
    $sql->execute();

    $usuario = $sql->fetch();

    // Valida se o usuário existe e verifica o hash da senha (password_verify)
    // Se no seu banco as senhas ainda forem texto puro, use: ($usuario && $senha === $usuario['senha'])
    if ($usuario && password_verify($senha, $usuario['senha'])) {
        
        // Regenera o ID da sessão por segurança contra Session Fixation
        session_regenerate_id(true);

        // Armazena as informações do usuário na sessão
        $_SESSION['usuario_id']    = $usuario['id'];
        $_SESSION['usuario_nome']  = $usuario['nome'];
        $_SESSION['usuario_email'] = $usuario['email'];

        $_SESSION['mensagem_sucesso'] = "Bem-vindo de volta, " . htmlspecialchars($usuario['nome']) . "!";
        header('Location: home.php');
        exit();

    } else {
        $_SESSION['mensagem_erro'] = "E-mail ou senha incorretos.";
        header('Location: login.php');
        exit();
    }

} catch (PDOException $e) {
    $_SESSION['mensagem_erro'] = "Erro ao tentar realizar o login. Tente novamente.";
    header('Location: login.php');
    exit();
}