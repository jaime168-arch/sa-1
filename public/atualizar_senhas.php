<?php
require_once __DIR__ . '/../config/conexao.php';

$result = $conn->query("SELECT id, email, senha FROM usuarios");

if (!$result) {
    die("Erro ao buscar usuários: " . $conn->error);
}

$atualizados = 0;

while ($usuario = $result->fetch_assoc()) {
    $info = password_get_info($usuario['senha']);

    if ($info['algo'] === 0) {
        $novoHash = password_hash($usuario['senha'], PASSWORD_DEFAULT);
        $update = $conn->prepare("UPDATE usuarios SET senha = ? WHERE id = ?");

        if (!$update) {
            die("Erro ao preparar atualização: " . $conn->error);
        }

        $update->bind_param("si", $novoHash, $usuario['id']);

        if (!$update->execute()) {
            die("Erro ao atualizar senha: " . $update->error);
        }

        $update->close();
        $atualizados++;
        echo "Senha do e-mail '{$usuario['email']}' convertida para hash com sucesso.<br>";
    }
}

$result->free();
$conn->close();

echo "<hr><strong>Concluído! Total de senhas atualizadas para hash seguro: $atualizados</strong>";