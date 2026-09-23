<?php
session_start();

require_once __DIR__ . '/../config/conexao.php';

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (!$id || $id <= 0) {
    $_SESSION['mensagem_erro'] = "Selecione um usuário válido para excluir.";
    header('Location: usuarios.php');
    exit();
}

try {
    $sql = $pdo->prepare("DELETE FROM usuarios WHERE id = :id");
    $sql->bindValue(':id', $id, PDO::PARAM_INT);
    $sql->execute();

    if ($sql->rowCount() > 0) {
        $_SESSION['mensagem_sucesso'] = "Usuário removido com sucesso!";
    } else {
        $_SESSION['mensagem_erro'] = "O usuário solicitado não foi encontrado.";
    }

} catch (PDOException $e) {
    if ($e->getCode() === '23000') {
        $_SESSION['mensagem_erro'] = "Este usuário não pode ser excluído pois possui registros vinculados no sistema.";
    } else {
        $_SESSION['mensagem_erro'] = "Ocorreu um problema ao tentar excluir o usuário.";
    }
}

header('Location: usuarios.php');
exit();