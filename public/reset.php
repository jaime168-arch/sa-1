<?php
require_once __DIR__ . '/../config/conexao.php';
$hashReal = password_hash('123456', PASSWORD_BCRYPT);

$stmt = $pdo->prepare("UPDATE usuarios SET senha = :senha WHERE email = 'admin@ismaga.com'");
$stmt->execute([':senha' => $hashReal]);

echo "Senha do admin@ismaga.com redefinida para <strong>123456</strong> com sucesso!";