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

    try {
        if ($id) {
            $sql = "UPDATE rotas SET origem = :origem, destino = :destino, distancia = :distancia, tempo_estimado = :tempo_estimado WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        } else {
            $sql = "INSERT INTO rotas (origem, destino, distancia, tempo_estimado) VALUES (:origem, :destino, :distancia, :tempo_estimado)";
            $stmt = $pdo->prepare($sql);
        }

        $stmt->bindValue(':origem', $origem);
        $stmt->bindValue(':destino', $destino);
        $stmt->bindValue(':distancia', $distancia);
        $stmt->bindValue(':tempo_estimado', $tempo_estimado);
        $stmt->execute();

        $_SESSION['mensagem_sucesso'] = $id ? "Rota atualizada com sucesso!" : "Rota adicionada com sucesso!";
        header("Location: rotas.php");
        exit;

    } catch (PDOException $e) {
        error_log("Erro ao salvar rota: " . $e->getMessage());
        $_SESSION['mensagem_erro'] = "Erro no MySQL: " . htmlspecialchars($e->getMessage());
        header("Location: " . ($id ? "rota-form.php?id=$id" : "rota-form.php"));
        exit;
    }
} else {
    header("Location: rotas.php");
    exit;
}