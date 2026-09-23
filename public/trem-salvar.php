<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: trens.php');
    exit();
}

$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
$codigo = filter_input(INPUT_POST, 'codigo_trem', FILTER_SANITIZE_SPECIAL_CHARS);
$nome = filter_input(INPUT_POST, 'nome_trem', FILTER_SANITIZE_SPECIAL_CHARS);
$capacidade = filter_input(INPUT_POST, 'capacidade', FILTER_SANITIZE_NUMBER_INT);
$status = filter_input(INPUT_POST, 'status_trem', FILTER_SANITIZE_SPECIAL_CHARS);
$modelo = filter_input(INPUT_POST, 'modelo', FILTER_SANITIZE_SPECIAL_CHARS);

if (empty($codigo) || empty($nome) || empty($capacidade) || empty($status)) {
    $_SESSION['mensagem_erro'] = "Preencha todos os campos obrigatórios para salvar o trem.";
    header('Location: trem-form.php' . ($id ? "?id={$id}" : ""));
    exit();
}

if (!empty($id)) {
    $_SESSION['mensagem_sucesso'] = "Trem #{$id} atualizado com sucesso!";
} else {
    $_SESSION['mensagem_sucesso'] = "Novo trem cadastrado com sucesso!";
}

header('Location: trens.php');
exit();