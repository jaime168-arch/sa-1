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

    // Consulta SQL adaptada para MySQLi nativo ($conn)
    $sql = "SELECT * FROM usuarios WHERE LOWER(email) = ? LIMIT 1";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $usuario = $resultado->fetch_assoc();

        if ($usuario) {
            if (isset($usuario['ativo']) && $usuario['ativo'] == 0) {
                $_SESSION['mensagem_erro'] = "Esta conta está inativa. Contacte o administrador.";
                header("Location: login.php");
                exit;
            }

            if (password_verify($senha, $usuario['senha'])) {
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
    } else {
        error_log("Erro ao autenticar usuário: " . $conn->error);
        $_SESSION['mensagem_erro'] = "Erro de conexão com o banco de dados.";
        header("Location: login.php");
        exit;
    }

} else {
    header("Location: login.php");
    exit;
}