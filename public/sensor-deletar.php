<?php
session_start();

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (!$id || $id <= 0) {
    $_SESSION['mensagem_erro'] = "Selecione um sensor válido para excluir.";
    header('Location: sensores.php');
    exit();
}

$_SESSION['mensagem_sucesso'] = "Sensor #{$id} removido com sucesso!";

header('Location: sensores.php');
exit();