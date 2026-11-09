<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['mensagem_erro'] = "Acesso negado.";
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/../config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id             = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $origem         = trim(filter_input(INPUT_POST, 'origem', FILTER_SANITIZE_SPECIAL_CHARS));
    $destino        = trim(filter_input(INPUT_POST, 'destino', FILTER_SANITIZE_SPECIAL_CHARS));
    $distancia      = filter_input(INPUT_POST, 'distancia', FILTER_VALIDATE_FLOAT);
    $tempo_estimado = trim(filter_input(INPUT_POST, 'tempo_estimado', FILTER_SANITIZE_SPECIAL_CHARS));

    if (!$origem || !$destino || $distancia === false || !$tempo_estimado) {
        $_SESSION['mensagem_erro'] = "Preencha todos os campos obrigatórios (*).";
        header("Location: " . ($id ? "rota-form.php?id=$id" : "rota-form.php"));
        exit;
    }

    if ($id) {
     
        $sql = "UPDATE rotas SET origem = ?, destino = ?, distancia = ?, tempo_estimado = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ssdsi", $origem, $destino, $distancia, $tempo_estimado, $id);
        }
    } else {
       
        $sql = "INSERT INTO rotas (origem, destino, distancia, tempo_estimado) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ssds", $origem, $destino, $distancia, $tempo_estimado);
        }
    }

    if ($stmt && $stmt->execute()) {
        $_SESSION['mensagem_sucesso'] = $id ? "Rota atualizada com sucesso!" : "Rota adicionada com sucesso!";
        header("Location: rotas.php");
        exit;
    } else {
        $erroMsg = $conn->error ?: ($stmt ? $stmt->error : "Erro na preparação do SQL");
        error_log("Erro ao salvar rota: " . $erroMsg);
        $_SESSION['mensagem_erro'] = "Erro no MySQL: " . htmlspecialchars($erroMsg);
        header("Location: " . ($id ? "rota-form.php?id=$id" : "rota-form.php"));
        exit;
    }
} else {
    header("Location: rotas.php");
    exit;
}