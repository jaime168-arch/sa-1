<?php
session_start();

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (!$id || $id <= 0) {
    $_SESSION['mensagem_erro'] = "Selecione uma rota válida para excluir.";
    header('Location: rotas.php');
    exit();
}

$_SESSION['mensagem_sucesso'] = "Rota #{$id} removida com sucesso!";

header('Location: rotas.php');
exit();