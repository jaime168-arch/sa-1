<?php
session_start();


if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['mensagem_erro'] = "Precisa de fazer login para aceder a esta página.";
    header("Location: login.php");
    exit;
}

if (($_SESSION['usuario_tipo'] ?? '') !== 'admin') {
    $_SESSION['mensagem_erro'] = "Acesso negado. Apenas administradores podem excluir registos.";
    header("Location: trens.php");
    exit;
}

require_once __DIR__ . '/../config/conexao.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    $_SESSION['mensagem_erro'] = "Identificador de trem inválido.";
    header("Location: trens.php");
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM trens WHERE id = :id");
    $sucesso = $stmt->execute([':id' => $id]);

    if ($sucesso && $stmt->rowCount() > 0) {
        $_SESSION['mensagem_sucesso'] = "Trem eliminado com sucesso!";
    } else {
        $_SESSION['mensagem_erro'] = "Trem não encontrado ou já eliminado.";
    }

} catch (PDOException $e) {
    if ($e->getCode() == '23000') {
        $_SESSION['mensagem_erro'] = "Não é possível eliminar este trem pois existem sensores ou dados vinculados a ele.";
    } else {
        $_SESSION['mensagem_erro'] = "Erro no banco de dados: " . $e->getMessage();
    }
}

header("Location: trens.php");
exit;