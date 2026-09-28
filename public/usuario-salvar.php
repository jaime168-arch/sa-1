<?php
session_start();
require_once __DIR__ . '/../config/conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 1. Tratamento e Limpeza dos Dados
    $id              = !empty($_POST['id']) ? (int)$_POST['id'] : null;
    $nome            = trim($_POST['nome'] ?? '');
    $email           = trim($_POST['email'] ?? '');
    $tipo            = $_POST['tipo'] ?? 'operador';
    $ativo           = isset($_POST['ativo']) ? (int)$_POST['ativo'] : 1;
    $senha           = $_POST['senha'] ?? '';
    $confirmar_senha = $_POST['confirmar_senha'] ?? '';

    // 2. Validações Iniciais
    if (empty($nome) || empty($email)) {
        $_SESSION['mensagem_erro'] = "Preencha o Nome e o E-mail.";
        header("Location: usuario-form.php" . ($id ? "?id=$id" : ""));
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['mensagem_erro'] = "E-mail inválido.";
        header("Location: usuario-form.php" . ($id ? "?id=$id" : ""));
        exit;
    }

    // Validação de Senha para Novo Usuário
    if (!$id && empty($senha)) {
        $_SESSION['mensagem_erro'] = "A senha é obrigatória para novos cadastros.";
        header("Location: usuario-form.php");
        exit;
    }

    if (!empty($senha) && $senha !== $confirmar_senha) {
        $_SESSION['mensagem_erro'] = "As senhas digitadas não coincidem.";
        header("Location: usuario-form.php" . ($id ? "?id=$id" : ""));
        exit;
    }

    try {
        // 3. Verificação de Duplicidade de E-mail
        if ($id) {
            $stmtCheck = $pdo->prepare("SELECT id FROM usuarios WHERE LOWER(email) = LOWER(:email) AND id != :id");
            $stmtCheck->execute([':email' => $email, ':id' => $id]);
        } else {
            $stmtCheck = $pdo->prepare("SELECT id FROM usuarios WHERE LOWER(email) = LOWER(:email)");
            $stmtCheck->execute([':email' => $email]);
        }

        if ($stmtCheck->fetch()) {
            $_SESSION['mensagem_erro'] = "O e-mail '$email' já está cadastrado em outra conta.";
            header("Location: usuario-form.php" . ($id ? "?id=$id" : ""));
            exit;
        }

        // 4. Execução do INSERT ou UPDATE
        if ($id) {
            // EDITAR
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
        } else {
            // INSERIR NOVO
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha, tipo, ativo) VALUES (:nome, :email, :senha, :tipo, :ativo)");
            $stmt->execute([
                ':nome'  => $nome,
                ':email' => $email,
                ':senha' => $senhaHash,
                ':tipo'  => $tipo,
                ':ativo' => $ativo
            ]);
            $_SESSION['mensagem_sucesso'] = "Usuário '$nome' cadastrado com sucesso!";
        }

        header("Location: usuarios.php");
        exit;

    } catch (PDOException $e) {
        // Exibe o erro exato do MySQL caso falhe
        $_SESSION['mensagem_erro'] = "Erro ao gravar no banco: " . $e->getMessage();
        header("Location: usuario-form.php" . ($id ? "?id=$id" : ""));
        exit;
    }
} else {
    header("Location: usuarios.php");
    exit;
}