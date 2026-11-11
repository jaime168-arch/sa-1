<?php
require_once __DIR__ . '/../config/conexao.php';

$novaSenha = password_hash('123456', PASSWORD_DEFAULT);
$emailAdmin = 'admin@ismaga.com';
$emailOperador = 'jailson@gmail.com';

$sqlAdmin = "UPDATE usuarios SET senha = ? WHERE email = ?";
$stmt = $conn->prepare($sqlAdmin);

if (!$stmt) {
    die("Erro ao preparar a atualização do admin: " . $conn->error);
}

$stmt->bind_param("ss", $novaSenha, $emailAdmin);

if (!$stmt->execute()) {
    die("Erro ao atualizar a senha do admin: " . $stmt->error);
}

$stmt->close();

$sqlOperador = "UPDATE usuarios SET senha = ? WHERE email = ?";
$stmt2 = $conn->prepare($sqlOperador);

if (!$stmt2) {
    die("Erro ao preparar a atualização do operador: " . $conn->error);
}

$stmt2->bind_param("ss", $novaSenha, $emailOperador);

if (!$stmt2->execute()) {
    die("Erro ao atualizar a senha do operador: " . $stmt2->error);
}

$stmt2->close();
$conn->close();

echo "<h3>Senhas atualizadas com sucesso!</h3>";
echo "<p>Agora você pode entrar com os seguintes dados:</p>";
echo "<ul>";
echo "<li><strong>Admin:</strong> admin@ismaga.com | <strong>Senha:</strong> 123456</li>";
echo "<li><strong>Operador:</strong> jailson@gmail.com | <strong>Senha:</strong> 123456</li>";
echo "</ul>";