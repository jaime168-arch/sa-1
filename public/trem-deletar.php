<?php
session_start();

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

// Se não houver ID válido, envia mensagem de aviso e retorna
if (!$id || $id <= 0) {
    $_SESSION['mensagem_erro'] = "Selecione um trem válido para excluir.";
    header('Location: trens.php');
    exit();
}

/*
 * Integração com o Banco de Dados (MySQL)
 * 
 * try {
 *     $pdo = new PDO("mysql:host=localhost;dbname=ja_ismaga;charset=utf8mb4", "root", "");
 *     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 * 
 *     $sql = $pdo->prepare("DELETE FROM trens WHERE id = :id");
 *     $sql->bindValue(':id', $id, PDO::PARAM_INT);
 *     $sql->execute();
 * 
 *     if ($sql->rowCount() > 0) {
 *         $_SESSION['mensagem_sucesso'] = "Trem removido com sucesso!";
 *     } else {
 *         $_SESSION['mensagem_erro'] = "O trem solicitado não foi encontrado.";
 *     }
 * 
 * } catch (PDOException $e) {
 *     // Trata retenção caso o trem tenha sensores ou viagens associados
 *     if ($e->getCode() === '23000') {
 *         $_SESSION['mensagem_erro'] = "Este trem não pode ser excluído pois possui sensores ou rotas vinculados a ele.";
 *     } else {
 *         $_SESSION['mensagem_erro'] = "Ocorreu um problema ao tentar excluir o trem.";
 *     }
 * }
 */

// Feedback temporário para testes na interface
$_SESSION['mensagem_sucesso'] = "Trem #{$id} removido com sucesso!";

header('Location: trens.php');
exit();