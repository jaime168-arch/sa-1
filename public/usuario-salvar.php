<?php
session_start();

// Verifica autenticação
if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['mensagem_erro'] = "Precisa de fazer login para aceder a esta página.";
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/../config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1. Recebe e trata os dados vindos do formulário
    $id              = !empty($_POST['id']) ? (int)$_POST['id'] : null;
    $nome            = trim($_POST['nome'] ?? '');
    $email           = strtolower(trim($_POST['email'] ?? '')); // Salva sempre em minúsculas
    $tipo            = $_POST['tipo'] ?? 'operador';
    $ativo           = isset($_POST['ativo']) ? (int)$_POST['ativo'] : 1;
    $senha           = $_POST['senha'] ?? '';
    $confirmar_senha = $_POST['confirmar_senha'] ?? '';

    // 2. Validações básicas de preenchimento
    if (empty($nome) || empty($email)) {
        $_SESSION['mensagem_erro'] = "Por favor, preencha o Nome Completo e o E-mail.";
        header("Location: usuario-form.php" . ($id ? "?id=$id" : ""));
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['mensagem_erro'] = "O e-mail digitado é inválido.";
        header("Location: usuario-form.php" . ($id ? "?id=$id" : ""));
        exit;
    }

    // Se for novo cadastro, a senha é obrigatória
    if (!$id && empty($senha)) {
        $_SESSION['mensagem_erro'] = "A senha é obrigatória para cadastrar um novo usuário.";
        header("Location: usuario-form.php");
        exit;
    }

    // Se informou senha, verifica se a confirmação bate
    if (!empty($senha) && $senha !== $confirmar_senha) {
        $_SESSION['mensagem_erro'] = "As senhas digitadas não coincidem.";
        header("Location: usuario-form.php" . ($id ? "?id=$id" : ""));
        exit;
    }

    try {
        // 3. Verifica se o e-mail já existe no banco
        if ($id) {
            $stmtCheck = $pdo->prepare("SELECT id FROM usuarios WHERE LOWER(email) = :email AND id != :id");
            $stmtCheck->execute([':email' => $email, ':id' => $id]);
        } else {
            $stmtCheck = $pdo->prepare("SELECT id FROM usuarios WHERE LOWER(email) = :email");
            $stmtCheck->execute([':email' => $email]);
        }

        if ($stmtCheck->fetch()) {
            $_SESSION['mensagem_erro'] = "O e-mail '$email' já está cadastrado para outro usuário.";
            header("Location: usuario-form.php" . ($id ? "?id=$id" : ""));
            exit;
        }

        // 4. Inserção ou Atualização na Base de Dados
        if ($id) {
            // EDITAR USUÁRIO
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
            // NOVO USUÁRIO
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

        // Redireciona para a listagem
        header("Location: usuarios.php");
        exit;

    } catch (PDOException $e) {
        // Exibe a mensagem de erro exata da base de dados caso haja falha
        $_SESSION['mensagem_erro'] = "Erro ao salvar na base de dados: " . $e->getMessage();
        header("Location: usuario-form.php" . ($id ? "?id=$id" : ""));
        exit;
    }

} else {
    header("Location: usuarios.php");
    exit;
}