<?php
session_start();

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (!$id || $id <= 0) {
    $_SESSION['mensagem_erro'] = "Selecione um trem válido para excluir.";
    header('Location: trens.php');
    exit();
}

$_SESSION['mensagem_sucesso'] = "Trem #{$id} removido com sucesso!";

header('Location: trens.php');
exit();