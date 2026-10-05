<?php
require_once __DIR__ . '/../config/conexao.php';

// Define a nova palavra-passe para o Administrador e para o Operador
$novaSenha = password_hash('123456', PASSWORD_DEFAULT);

try {
    // Atualiza a senha do Admin
    $stmt = $pdo->prepare("UPDATE usuarios SET senha = :senha WHERE email = 'admin@ismaga.com'");
    $stmt->execute([':senha' => $novaSenha]);

    // Atualiza a senha do Jailson
    $stmt2 = $pdo->prepare("UPDATE usuarios SET senha = :senha WHERE email = 'jailson@gmail.com'");
    $stmt2->execute([':senha' => $novaSenha]);

    echo "<h3> Palavras-passe atualizadas com sucesso!</h3>";
    echo "<p>Agora podes entrar com os seguintes dados:</p>";
    echo "<ul>";
    echo "<li><strong>Admin:</strong> admin@ismaga.com | <strong>Senha:</strong> 123456</li>";
    echo "<li><strong>Operador:</strong> jailson@gmail.com | <strong>Senha:</strong> 123456</li>";
    echo "</ul>";

} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}