<?php
require_once __DIR__ . '/../config/conexao.php';

$novaSenha = password_hash('123456', PASSWORD_BCRYPT);
$emailAdmin = 'admin@ismaga.com';

$sql = "UPDATE usuarios SET senha = ? WHERE email = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Erro ao preparar a atualização: " . $conn->error);
}

$stmt->bind_param("ss", $novaSenha, $emailAdmin);

if (!$stmt->execute()) {
    die("Erro ao redefinir a senha: " . $stmt->error);
}

if ($stmt->affected_rows > 0) {
    echo "Senha do admin@ismaga.com redefinida para <strong>123456</strong> com sucesso!";
} else {
    echo "Nenhum usuário encontrado para o e-mail admin@ismaga.com.";
}

$stmt->close();
$conn->close();