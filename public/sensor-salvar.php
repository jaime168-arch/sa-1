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

    try {
        if ($id) {
            $sql = "UPDATE sensores SET codigo_sensor = :codigo_sensor, tipo = :tipo, localizacao = :localizacao, status_leitura = :status_leitura, trem_id = :trem_id WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        } else {
            $sql = "INSERT INTO sensores (codigo_sensor, tipo, localizacao, status_leitura, trem_id) VALUES (:codigo_sensor, :tipo, :localizacao, :status_leitura, :trem_id)";
            $stmt = $pdo->prepare($sql);
        }

        $stmt->bindValue(':codigo_sensor', $codigo_sensor);
        $stmt->bindValue(':tipo', $tipo);
        $stmt->bindValue(':localizacao', $localizacao);
        $stmt->bindValue(':status_leitura', $status_leitura);
        $stmt->bindValue(':trem_id', $trem_id, PDO::PARAM_INT);
        $stmt->execute();

        $_SESSION['mensagem_sucesso'] = $id ? "Sensor atualizado com sucesso!" : "Sensor registado com sucesso!";
        header("Location: sensores.php");
        exit;

    } catch (PDOException $e) {
        error_log("Erro ao salvar sensor: " . $e->getMessage());
        $_SESSION['mensagem_erro'] = "Erro no MySQL: " . htmlspecialchars($e->getMessage());
        header("Location: " . ($id ? "sensor-form.php?id=$id" : "sensor-form.php"));
        exit;
    }
} else {
    header("Location: sensores.php");
    exit;
}