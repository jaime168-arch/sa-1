<?php
session_start();

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

// Se não houver ID válido, envia mensagem de aviso e retorna
if (!$id || $id <= 0) {
    $_SESSION['mensagem_erro'] = "Selecione um sensor válido para excluir.";
    header('Location: sensores.php');
    exit();
}

/*
 * Integração com o Banco de Dados (MySQL)
 * 
 * try {
 *     $pdo = new PDO("mysql:host=localhost;dbname=ja_ismaga;charset=utf8mb4", "root", "");
 *     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 * 
 *     $sql = $pdo->prepare("DELETE FROM sensores WHERE id = :id");
 *     $sql->bindValue(':id', $id, PDO::PARAM_INT);
 *     $sql->execute();
 * 
 *     if ($sql->rowCount() > 0) {
 *         $_SESSION['mensagem_sucesso'] = "Sensor removido com sucesso!";
 *     } else {
 *         $_SESSION['mensagem_erro'] = "O sensor solicitado não foi encontrado.";
 *     }
 * 
 * } catch (PDOException $e) {
 *     $_SESSION['mensagem_erro'] = "Ocorreu um problema ao tentar excluir o sensor.";
 * }
 */

// Feedback temporário para testes na interface
$_SESSION['mensagem_sucesso'] = "Sensor #{$id} removido com sucesso!";

header('Location: sensores.php');
exit();