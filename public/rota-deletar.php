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

// Instrução SQL adaptada para MySQLi nativo ($conn)
$sql = "DELETE FROM rotas WHERE id = ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $_SESSION['mensagem_sucesso'] = "Rota eliminada com sucesso!";
        } else {
            $_SESSION['mensagem_erro'] = "Rota não encontrada ou já eliminada.";
        }
    } else {
        // Trata erro de integridade referencial / Chave Estrangeira (FK)
        if ($conn->errno == 1451) {
            $_SESSION['mensagem_erro'] = "Não é possível excluir esta rota pois existem trens ou registros vinculados a ela.";
        } else {
            $_SESSION['mensagem_erro'] = "Erro ao excluir rota no banco de dados: " . $conn->error;
        }
    }
} else {
    $_SESSION['mensagem_erro'] = "Erro na preparação da consulta: " . $conn->error;
}

header("Location: rotas.php");
exit;