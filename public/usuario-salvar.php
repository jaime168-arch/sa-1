<?php
session_start();

// Proteção de acesso: verifica se o utilizador está autenticado
if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['mensagem_erro'] = "Acesso não autorizado.";
    header("Location: login.php");
    exit;
}

// Conexão com o banco de dados via PDO
require_once __DIR__ . '/../config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Captura e sanitiza os dados do formulário
    $id             = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $nome           = trim(filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS));
    $email          = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $senha          = $_POST['senha'] ?? '';
    $perfil         = trim($_POST['perfil'] ?? 'operador');
    $status_usuario = trim($_POST['status_usuario'] ?? 'ativo');

    // Validação de campos obrigatórios mínimos
    if (!$nome || !$email) {
        $_SESSION['mensagem_erro'] = "Preencha todos os campos obrigatórios (*).";
        header("Location: " . ($id ? "usuario-form.php?id=$id" : "usuario-form.php"));
        exit;
    }

    try {
        // Verifica se as colunas 'perfil' e 'status_usuario' existem na tabela
        $columns = $pdo->query("SHOW COLUMNS FROM usuarios")->fetchAll(PDO::FETCH_COLUMN);
        $hasPerfil = in_array('perfil', $columns);
        $hasStatus = in_array('status_usuario', $columns);

        if (!empty($id)) {
            // --- EDIÇÃO DE UTILIZADOR ---
            $fields = ["nome = :nome", "email = :email"];
            
            if (!empty($senha)) {
                $fields[] = "senha = :senha";
            }
            if ($hasPerfil) {
                $fields[] = "perfil = :perfil";
            }
            if ($hasStatus) {
                $fields[] = "status_usuario = :status_usuario";
            }

            $sql = "UPDATE usuarios SET " . implode(", ", $fields) . " WHERE id = :id";
            $stmt = $pdo->prepare($sql);

            $stmt->bindValue(':nome', $nome);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);

            if (!empty($senha)) {
                $stmt->bindValue(':senha', password_hash($senha, PASSWORD_BCRYPT));
            }
            if ($hasPerfil) {
                $stmt->bindValue(':perfil', $perfil);
            }
            if ($hasStatus) {
                $stmt->bindValue(':status_usuario', $status_usuario);
            }

            $stmt->execute();
            $_SESSION['mensagem_sucesso'] = "Utilizador atualizado com sucesso!";

        } else {
            // --- CRIAÇÃO DE NOVO UTILIZADOR ---
            if (empty($senha)) {
                $_SESSION['mensagem_erro'] = "A senha é obrigatória para novos utilizadores.";
                header("Location: usuario-form.php");
                exit;
            }

            $cols = ["nome", "email", "senha"];
            $params = [":nome", ":email", ":senha"];

            if ($hasPerfil) {
                $cols[] = "perfil";
                $params[] = ":perfil";
            }
            if ($hasStatus) {
                $cols[] = "status_usuario";
                $params[] = ":status_usuario";
            }

            $sql = "INSERT INTO usuarios (" . implode(", ", $cols) . ") VALUES (" . implode(", ", $params) . ")";
            $stmt = $pdo->prepare($sql);

            $stmt->bindValue(':nome', $nome);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':senha', password_hash($senha, PASSWORD_BCRYPT));

            if ($hasPerfil) {
                $stmt->bindValue(':perfil', $perfil);
            }
            if ($hasStatus) {
                $stmt->bindValue(':status_usuario', $status_usuario);
            }

            $stmt->execute();
            $_SESSION['mensagem_sucesso'] = "Utilizador cadastrado com sucesso!";
        }

        header("Location: usuarios.php");
        exit;

    } catch (PDOException $e) {
        error_log("Erro no MySQL: " . $e->getMessage());
        $_SESSION['mensagem_erro'] = "Erro ao guardar no banco de dados: " . htmlspecialchars($e->getMessage());
        header("Location: " . ($id ? "usuario-form.php?id=$id" : "usuario-form.php"));
        exit;
    }
} else {
    header("Location: usuarios.php");
    exit;
}