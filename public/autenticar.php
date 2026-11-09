<?php
require_once __DIR__ . '/../config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = trim($_POST['senha'] ?? '');

    if (empty($email) || empty($senha)) {
        header("Location: login.php?erro=campos_vazios");
        exit;
    }

    $sql = "SELECT id, nome, email, senha, tipo, ativo FROM usuarios WHERE email = ? LIMIT 1";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("<div style='font-family:sans-serif; padding:20px; color:red;'>
                <h3>Erro de SQL no prepare():</h3>
                <p>" . htmlspecialchars($conn->error) . "</p>
                <p><strong>Dica:</strong> Verifique se a tabela 'usuarios' e a coluna 'email' existem no banco de dados.</p>
             </div>");
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();

    $resultado = $stmt->get_result();

    if ($usuario = $resultado->fetch_assoc()) {
        if ($usuario['ativo'] != 1) {
            header("Location: login.php?erro=usuario_inativo");
            exit;
        }

        if (password_verify($senha, $usuario['senha']) || $senha === $usuario['senha']) {
            $_SESSION['usuario_id']   = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            $_SESSION['usuario_tipo'] = $usuario['tipo'];

            header("Location: home.php");
            exit;
        }
    }

    header("Location: login.php?erro=dados_invalidos");
    exit;
} else {
    header("Location: login.php");
    exit;
}