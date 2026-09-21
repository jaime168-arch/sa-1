<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: rotas.php');
    exit();
}

$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
$codigo = filter_input(INPUT_POST, 'codigo_rota', FILTER_SANITIZE_SPECIAL_CHARS);
$nome = filter_input(INPUT_POST, 'nome_rota', FILTER_SANITIZE_SPECIAL_CHARS);
$origem = filter_input(INPUT_POST, 'origem', FILTER_SANITIZE_SPECIAL_CHARS);
$destino = filter_input(INPUT_POST, 'destino', FILTER_SANITIZE_SPECIAL_CHARS);
$distancia = filter_input(INPUT_POST, 'distancia_km', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
$status = filter_input(INPUT_POST, 'status_rota', FILTER_SANITIZE_SPECIAL_CHARS);

if (empty($codigo) || empty($nome) || empty($origem) || empty($destino)) {
    $_SESSION['mensagem_erro'] = "Preencha todos os campos obrigatórios para salvar a rota.";
    header('Location: rota-form.php' . ($id ? "?id={$id}" : ""));
    exit();
}

if (!empty($id)) {
    $_SESSION['mensagem_sucesso'] = "Rota #{$id} atualizada com sucesso!";
} else {
    $_SESSION['mensagem_sucesso'] = "Nova rota cadastrada com sucesso!";
}

header('Location: rotas.php');
exit();