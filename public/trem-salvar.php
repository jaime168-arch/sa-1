<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['mensagem_erro'] = "Acesso negado.";
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/../config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id         = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $codigo     = trim(filter_input(INPUT_POST, 'codigo', FILTER_SANITIZE_SPECIAL_CHARS));
    $modelo     = trim(filter_input(INPUT_POST, 'modelo', FILTER_SANITIZE_SPECIAL_CHARS));
    $capacidade = filter_input(INPUT_POST, 'capacidade', FILTER_VALIDATE_INT);
    $status     = trim($_POST['status'] ?? 'Em Operação');

    if (!$codigo || !$modelo || !$capacidade) {
        $_SESSION['mensagem_erro'] = "Preencha todos os campos obrigatórios (*).";
        header("Location: " . ($id ? "trem-form.php?id=$id" : "trem-form.php"));
        exit;
    }

    try {
        if ($id) {
            $sql = "UPDATE trens SET codigo = :codigo, modelo = :modelo, capacidade = :capacidade, status = :status WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        } else {
            $sql = "INSERT INTO trens (codigo, modelo, capacidade, status) VALUES (:codigo, :modelo, :capacidade, :status)";
            $stmt = $pdo->prepare($sql);
        }

        $stmt->bindValue(':codigo', $codigo);
        $stmt->bindValue(':modelo', $modelo);
        $stmt->bindValue(':capacidade', $capacidade, PDO::PARAM_INT);
        $stmt->bindValue(':status', $status);
        $stmt->execute();

        $_SESSION['mensagem_sucesso'] = $id ? "Trem atualizado com sucesso!" : "Trem adicionado com sucesso!";
        header("Location: trens.php");
        exit;

    } catch (PDOException $e) {
        error_log("Erro ao salvar trem: " . $e->getMessage());
        if ($e->getCode() == 23000) {
            $_SESSION['mensagem_erro'] = "O código do trem informado já existe.";
        } else {
            $_SESSION['mensagem_erro'] = "Erro no MySQL: " . htmlspecialchars($e->getMessage());
        }
        header("Location: " . ($id ? "trem-form.php?id=$id" : "trem-form.php"));
        exit;
    }
} else {
    header("Location: trens.php");
    exit;
}