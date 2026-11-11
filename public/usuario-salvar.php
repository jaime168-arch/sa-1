<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/../config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id    = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $nome  = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $tipo  = trim($_POST['tipo'] ?? 'operador');
    $ativo = isset($_POST['ativo']) ? (int)$_POST['ativo'] : 1;

    if (empty($nome) || empty($email)) {
        $_SESSION['mensagem_erro'] = "Preencha os campos obrigatórios (Nome e E-mail).";
        header("Location: usuario-form.php" . ($id ? "?id=$id" : ""));
        exit;
    }

    if ($id) {

        if (!empty($senha)) {

            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
            $sql = "UPDATE usuarios SET nome = ?, email = ?, senha = ?, tipo = ?, ativo = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);

            if (!$stmt) {
                die("Erro no prepare (UPDATE com senha): " . $conn->error);
            }

            $stmt->bind_param("ssssii", $nome, $email, $senhaHash, $tipo, $ativo, $id);
        } else {
            $sql = "UPDATE usuarios SET nome = ?, email = ?, tipo = ?, ativo = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);

            if (!$stmt) {
                die("Erro no prepare (UPDATE sem senha): " . $conn->error);
            }

            $stmt->bind_param("sssii", $nome, $email, $tipo, $ativo, $id);
        }
    } else {
 
        if (empty($senha)) {
            $_SESSION['mensagem_erro'] = "A senha é obrigatória para novos usuários.";
            header("Location: usuario-form.php");
            exit;
        }

        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuarios (nome, email, senha, tipo, ativo) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            die("Erro no prepare (INSERT): " . $conn->error);
        }

        $stmt->bind_param("ssssi", $nome, $email, $senhaHash, $tipo, $ativo);
    }


    if ($stmt->execute()) {
        $_SESSION['mensagem_sucesso'] = $id ? "Usuário atualizado com sucesso!" : "Usuário cadastrado com sucesso!";
        header("Location: usuarios.php");
    } else {
        $_SESSION['mensagem_erro'] = "Erro ao salvar no banco de dados: " . $stmt->error;
        header("Location: usuario-form.php" . ($id ? "?id=$id" : ""));
    }
    exit;
} else {
    header("Location: usuarios.php");
    exit;
}