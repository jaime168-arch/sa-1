<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: sensores.php');
    exit();
}

$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
$codigo = filter_input(INPUT_POST, 'codigo_sensor', FILTER_SANITIZE_SPECIAL_CHARS);
$tipo = filter_input(INPUT_POST, 'tipo_sensor', FILTER_SANITIZE_SPECIAL_CHARS);
$tremId = filter_input(INPUT_POST, 'trem_id', FILTER_SANITIZE_NUMBER_INT);
$rotaId = filter_input(INPUT_POST, 'rota_id', FILTER_SANITIZE_NUMBER_INT);
$pinoEsp32 = filter_input(INPUT_POST, 'pino_esp32', FILTER_SANITIZE_SPECIAL_CHARS);
$status = filter_input(INPUT_POST, 'status_sensor', FILTER_SANITIZE_SPECIAL_CHARS);
$descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_SPECIAL_CHARS);

if (empty($codigo) || empty($tipo) || empty($pinoEsp32) || empty($status)) {
    $_SESSION['mensagem_erro'] = "Preencha todos os campos obrigatórios para salvar o sensor.";
    header('Location: sensor-form.php' . ($id ? "?id={$id}" : ""));
    exit();
}

if (!empty($id)) {
    $_SESSION['mensagem_sucesso'] = "Sensor #{$id} atualizado com sucesso!";
} else {
    $_SESSION['mensagem_sucesso'] = "Novo sensor IoT cadastrado com sucesso!";
}

header('Location: sensores.php');
exit();