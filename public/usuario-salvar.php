<?php
session_start();
require_once __DIR__ . '/../config/conexao.php'; // Ajuste o caminho para conexao.php se necessário

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Captura os dados do formulário
    $id              = !empty($_POST['id']) ? (int)$_POST['id'] : null;
    $nome            = trim($_POST['nome'] ?? '');
    $email           = trim($_POST['email'] ?? '');
    $tipo            = $_POST['tipo'] ?? 'operador';
    $ativo           = isset($_POST['ativo']) ? (int)$_POST['ativo'] : 1;
    $senha           = $_POST['senha'] ?? '';
    $confirmar_senha = $_POST['confirmar_senha'] ?? '';

    // Validar campos obrigatórios (Nome e E-mail)
    if (empty($nome) || empty($email)) {
        $_SESSION['mensagem_erro'] = "Preencha o Nome e o E-mail.";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['mensagem_erro'] = "O e-mail digitado não é válido.";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }

    // Se for CADASTRO NOVO ($id está vazio), a senha é obrigatória
    if (!$id && empty($senha)) {
        $_SESSION['mensagem_erro'] = "A senha é obrigatória para novos usuários.";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }

    // Se digitou algo no campo de senha, as senhas precisam coincidir
    if (!empty($senha) && $senha !== $confirmar_senha) {
        $_SESSION['mensagem_erro'] = "As senhas não coincidem.";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }

    try {
        // Verificar se o e-mail já pertence a OUTRO usuário
        if ($id) {
            $stmtCheck = $pdo->prepare("SELECT id FROM usuarios WHERE LOWER(email) = LOWER(:email) AND id != :id");
            $stmtCheck->execute([':email' => $email, ':id' => $id]);
        } else {
            $stmtCheck = $pdo->prepare("SELECT id FROM usuarios WHERE LOWER(email) = LOWER(:email)");
            $stmtCheck->execute([':email' => $email]);
        }

        if ($stmtCheck->fetch()) {
            $_SESSION['mensagem_erro'] = "Este e-mail já está sendo utilizado por outro usuário.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }

        // --- MODO 1: EDIÇÃO (UPDATE) ---
        if ($id) {
            // Se preencheu a nova senha, atualizamos com a nova senha criptografada
            if (!empty($senha)) {
                $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("UPDATE usuarios SET nome = :nome, email = :email, tipo = :tipo, ativo = :ativo, senha = :senha WHERE id = :id");
                $stmt->execute([
                    ':nome'  => $nome,
                    ':email' => $email,
                    ':tipo'  => $tipo,
                    ':ativo' => $ativo,
                    ':senha' => $senhaHash,
                    ':id'    => $id
                ]);
            } else {
                // Se deixou a senha em branco, atualiza os dados sem alterar a senha
                $stmt = $pdo->prepare("UPDATE usuarios SET nome = :nome, email = :email, tipo = :tipo, ativo = :ativo WHERE id = :id");
                $stmt->execute([
                    ':nome'  => $nome,
                    ':email' => $email,
                    ':tipo'  => $tipo,
                    ':ativo' => $ativo,
                    ':id'    => $id
                ]);
            }

            $_SESSION['mensagem_sucesso'] = "Usuário atualizado com sucesso!";
            header("Location: usuarios.php");
            exit;

        } 
        // --- MODO 2: NOVO CADASTRO (INSERT) ---
        else {
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, tipo, ativo, senha) VALUES (:nome, :email, :tipo, :ativo, :senha)");
            $stmt->execute([
                ':nome'  => $nome,
                ':email' => $email,
                ':tipo'  => $tipo,
                ':ativo' => $ativo,
                ':senha' => $senhaHash
            ]);

            $_SESSION['mensagem_sucesso'] = "Novo usuário criado com sucesso!";
            header("Location: usuarios.php");
            exit;
        }

    } catch (PDOException $e) {
        $_SESSION['mensagem_erro'] = "Erro no MySQL: " . $e->getMessage();
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }

} else {
    header("Location: usuarios.php");
    exit;
}