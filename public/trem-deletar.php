<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['mensagem_erro'] = "Acesso negado.";
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/../config/conexao.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($id) {
    try {
        $stmt = $pdo->prepare("DELETE FROM trens WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $_SESSION['mensagem_sucesso'] = "Trem removido com sucesso!";
    } catch (PDOException $e) {
        error_log("Erro ao deletar trem: " . $e->getMessage());
        $_SESSION['mensagem_erro'] = "Não foi possível remover o trem.";
    }
}

header("Location: trens.php");
exit;