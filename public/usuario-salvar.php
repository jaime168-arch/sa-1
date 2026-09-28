<?php
session_start();
require_once __DIR__ . '/../config/conexao.php';
if (!isset($_SESSION['usuario_id']) || ($_SESSION['usuario_tipo'] ?? '') !== 'admin') {
    $_SESSION['mensagem_erro'] = "Acesso negado. Apenas administradores podem cadastrar usuários.";
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id     = !empty($_POST['id']) ? (int)$_POST['id'] : null;
    $nome   = trim($_POST['nome'] ?? '');
    $email  = strtolower(trim($_POST['email'] ?? ''));
    $tipo   = $_POST['tipo'] ?? 'operador';
    $ativo  = isset($_POST['ativo']) ? (int)$_POST['ativo'] : 1;
    $senha  = $_POST['senha'] ?? '';
    if (empty($nome) || empty($email)) {
        $_SESSION['mensagem_erro'] = "Preencha o Nome e o E-mail.";
        header("Location: usuario-form.php" . ($id ? "?id=$id" : ""));
        exit;
    }

    try {
        if ($id) {
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
            // NOVO CADASTRO PELO ADMIN
            if (empty($senha)) {
                $_SESSION['mensagem_erro'] = "A senha é obrigatória para cadastrar um novo usuário.";
                header("Location: usuario-form.php");
                exit;
            }

            // Verifica se o e-mail já existe
            $stmtCheck = $pdo->prepare("SELECT id FROM usuarios WHERE LOWER(email) = :email LIMIT 1");
            $stmtCheck->execute([':email' => $email]);

            if ($stmtCheck->fetch()) {
                $_SESSION['mensagem_erro'] = "O e-mail '$email' já está cadastrado no sistema.";
                header("Location: usuario-form.php");
                exit;
            }

            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha, tipo, ativo, trem_id) VALUES (:nome, :email, :senha, :tipo, :ativo, NULL)");
            $stmt->execute([
                ':nome'  => $nome,
                ':email' => $email,
                ':senha' => $senhaHash,
                ':tipo'  => $tipo,
                ':ativo' => $ativo
            ]);

            $_SESSION['mensagem_sucesso'] = "Usuário '$nome' cadastrado com sucesso pelo Administrador!";
        }

        header("Location: usuarios.php");
        exit;

    } catch (PDOException $e) {
        $_SESSION['mensagem_erro'] = "Erro do MySQL no banco de dados: " . $e->getMessage();
        header("Location: usuario-form.php" . ($id ? "?id=$id" : ""));
        exit;
    }

} else {
    header("Location: usuarios.php");
    exit;
}