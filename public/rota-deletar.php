<?php
session_start();

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

// Se não houver ID válido, envia mensagem de aviso e retorna
if (!$id || $id <= 0) {
    $_SESSION['mensagem_erro'] = "Selecione uma rota válida para excluir.";
    header('Location: rotas.php');
    exit();
}

/*
 * Integração com o Banco de Dados (MySQL)
 * 
 * try {
 *     $pdo = new PDO("mysql:host=localhost;dbname=ja_ismaga;charset=utf8mb4", "root", "");
 *     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 * 
 *     $sql = $pdo->prepare("DELETE FROM rotas WHERE id = :id");
 *     $sql->bindValue(':id', $id, PDO::PARAM_INT);
 *     $sql->execute();
 * 
 *     if ($sql->rowCount() > 0) {
 *         $_SESSION['mensagem_sucesso'] = "Rota removida com sucesso!";
 *     } else {
 *         $_SESSION['mensagem_erro'] = "A rota solicitada não foi encontrada.";
 *     }
 * 
 * } catch (PDOException $e) {
 *     // Evita erro de integridade caso haja registros vinculados
 *     if ($e->getCode() === '23000') {
 *         $_SESSION['mensagem_erro'] = "Esta rota não pode ser excluída pois tem sensores ou trens vinculados.";
 *     } else {
 *         $_SESSION['mensagem_erro'] = "Ocorreu um problema ao tentar excluir a rota.";
 *     }
 * }
 */

// Feedback temporário para testes na interface
$_SESSION['mensagem_sucesso'] = "Rota #{$id} removida com sucesso!";

header('Location: rotas.php');
exit();