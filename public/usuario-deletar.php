<?php
session_start();

// Inclui o arquivo de conexão com o banco de dados
require_once __DIR__ . '/../config/conexao.php';

// Captura e sanitiza o ID do usuário enviado via GET
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

// Se não houver um ID válido, redireciona com mensagem de aviso
if (!$id || $id <= 0) {
    $_SESSION['mensagem_erro'] = "Selecione um usuário válido para excluir.";
    header('Location: usuarios.php');
    exit();
}

try {
    // Prepara e executa a exclusão no banco de dados
    $sql = $pdo->prepare("DELETE FROM usuarios WHERE id = :id");
    $sql->bindValue(':id', $id, PDO::PARAM_INT);
    $sql->execute();

    // Verifica se algum registro foi realmente afetado
    if ($sql->rowCount() > 0) {
        $_SESSION['mensagem_sucesso'] = "Usuário removido com sucesso!";
    } else {
        $_SESSION['mensagem_erro'] = "O usuário solicitado não foi encontrado.";
    }

} catch (PDOException $e) {
    // Trata erros de chave estrangeira caso o usuário tenha registros vinculados
    if ($e->getCode() === '23000') {
        $_SESSION['mensagem_erro'] = "Este usuário não pode ser excluído pois possui registros vinculados no sistema.";
    } else {
        $_SESSION['mensagem_erro'] = "Ocorreu um problema ao tentar excluir o usuário.";
    }
}

// Redireciona de volta para a listagem de usuários
header('Location: usuarios.php');
exit();