<?php
require_once __DIR__ . '/../config/conexao.php';

try {
   
    $stmt = $pdo->query("SELECT id, email, senha FROM usuarios");
    $usuarios = $stmt->fetchAll();

    $atualizados = 0;

    foreach ($usuarios as $u) {
       
        $info = password_get_info($u['senha']);
        
        if ($info['algo'] === 0) {
            $novoHash = password_hash($u['senha'], PASSWORD_DEFAULT);
            $update = $pdo->prepare("UPDATE usuarios SET senha = :senha WHERE id = :id");
            $update->execute([':senha' => $novoHash, ':id' => $u['id']]);
            $atualizados++;
            echo "Senha do e-mail '{$u['email']}' convertida para Hash com sucesso.<br>";
        }
    }

    echo "<hr><strong>Concluído! Total de senhas atualizadas para Hash seguro: $atualizados</strong>";

} catch (PDOException $e) {
    die("Erro ao atualizar senhas: " . $e->getMessage());
}