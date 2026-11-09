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
    $sql = "DELETE FROM sensores WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $_SESSION['mensagem_sucesso'] = "Sensor removido com sucesso!";
            } else {
                $_SESSION['mensagem_erro'] = "Sensor não encontrado ou já removido.";
            }
        } else {
            error_log("Erro ao deletar sensor: " . $conn->error);
            $_SESSION['mensagem_erro'] = "Não foi possível remover o sensor.";
        }
    } else {
        error_log("Erro no prepare SQL: " . $conn->error);
        $_SESSION['mensagem_erro'] = "Erro na preparação da consulta no banco de dados.";
    }
}

header("Location: sensores.php");
exit;