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
    $codigo_sensor  = trim(filter_input(INPUT_POST, 'codigo_sensor', FILTER_SANITIZE_SPECIAL_CHARS));
    $tipo           = trim(filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_SPECIAL_CHARS));
    $localizacao    = trim(filter_input(INPUT_POST, 'localizacao', FILTER_SANITIZE_SPECIAL_CHARS));
    $status_leitura = trim(filter_input(INPUT_POST, 'status_leitura', FILTER_SANITIZE_SPECIAL_CHARS));
    $trem_id        = filter_input(INPUT_POST, 'trem_id', FILTER_VALIDATE_INT);

    if (!$codigo_sensor || !$tipo || !$localizacao || !$status_leitura || !$trem_id) {
        $_SESSION['mensagem_erro'] = "Preencha todos os campos obrigatórios (*), incluindo a escolha do Trem.";
        header("Location: " . ($id ? "sensor-form.php?id=$id" : "sensor-form.php"));
        exit;
    }

    if ($id) {
        $sql = "UPDATE sensores SET codigo_sensor = ?, tipo = ?, localizacao = ?, status_leitura = ?, trem_id = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ssssii", $codigo_sensor, $tipo, $localizacao, $status_leitura, $trem_id, $id);
        }
    } else {
        $sql = "INSERT INTO sensores (codigo_sensor, tipo, localizacao, status_leitura, trem_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ssssi", $codigo_sensor, $tipo, $localizacao, $status_leitura, $trem_id);
        }
    }

    if ($stmt && $stmt->execute()) {
        $_SESSION['mensagem_sucesso'] = $id ? "Sensor atualizado com sucesso!" : "Sensor registado com sucesso!";
        header("Location: sensores.php");
        exit;
    } else {
        $erroMsg = $conn->error ?: ($stmt ? $stmt->error : "Erro na preparação do SQL");
        error_log("Erro ao salvar sensor: " . $erroMsg);
        $_SESSION['mensagem_erro'] = "Erro no MySQL: " . htmlspecialchars($erroMsg);
        header("Location: " . ($id ? "sensor-form.php?id=$id" : "sensor-form.php"));
        exit;
    }
} else {
    header("Location: sensores.php");
    exit;
}