<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['mensagem_erro'] = "Precisa de fazer login para aceder a esta página.";
    header("Location: login.php");
    exit;
}

if (($_SESSION['usuario_tipo'] ?? '') !== 'admin') {
    $_SESSION['mensagem_erro'] = "Acesso negado: Apenas administradores podem excluir rotas.";
    header("Location: rotas.php");
    exit;
}

require_once __DIR__ . '/../config/conexao.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    $_SESSION['mensagem_erro'] = "Identificador de rota inválido.";
    header("Location: rotas.php");
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM rotas WHERE id = :id");
    $sucesso = $stmt->execute([':id' => $id]);

    if ($sucesso && $stmt->rowCount() > 0) {
        $_SESSION['mensagem_sucesso'] = "Rota eliminada com sucesso!";
    } else {
        $_SESSION['mensagem_erro'] = "Rota não encontrada ou já eliminada.";
    }

} catch (PDOException $e) {
    $_SESSION['mensagem_erro'] = "Erro ao excluir rota no banco de dados: " . $e->getMessage();
}

header("Location: rotas.php");
exit;