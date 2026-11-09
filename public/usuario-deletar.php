<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

if (($_SESSION['usuario_tipo'] ?? '') !== 'admin') {
    $_SESSION['mensagem_erro'] = "Apenas administradores podem excluir utilizadores.";
    header("Location: usuarios.php");
    exit;
}

require_once __DIR__ . '/../config/conexao.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    $_SESSION['mensagem_erro'] = "ID de utilizador inválido.";
    header("Location: usuarios.php");
    exit;
}


if ($id === (int)$_SESSION['usuario_id'] || $id === 1) {
    $_SESSION['mensagem_erro'] = "Não é permitido excluir a sua própria conta ou o administrador principal.";
    header("Location: usuarios.php");
    exit;
}


$sql = "DELETE FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("<div style='font-family:sans-serif; padding:20px; color:red;'>
            <h3>Erro no prepare() ao excluir usuário:</h3>
            <p>" . htmlspecialchars($conn->error) . "</p>
         </div>");
}


$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    $_SESSION['mensagem_sucesso'] = "Utilizador excluído com sucesso!";
} else {
    $_SESSION['mensagem_erro'] = "Erro ao excluir utilizador: " . $stmt->error;
}

header("Location: usuarios.php");
exit;