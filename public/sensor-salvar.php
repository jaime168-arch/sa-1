<?php
session_start();

// Aceita apenas envios via formulário (POST)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: sensores.php');
    exit();
}

// Captura e limpa os dados recebidos do formulário
$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
$codigo = filter_input(INPUT_POST, 'codigo_sensor', FILTER_SANITIZE_SPECIAL_CHARS);
$tipo = filter_input(INPUT_POST, 'tipo_sensor', FILTER_SANITIZE_SPECIAL_CHARS);
$tremId = filter_input(INPUT_POST, 'trem_id', FILTER_SANITIZE_NUMBER_INT);
$rotaId = filter_input(INPUT_POST, 'rota_id', FILTER_SANITIZE_NUMBER_INT);
$pinoEsp32 = filter_input(INPUT_POST, 'pino_esp32', FILTER_SANITIZE_SPECIAL_CHARS);
$status = filter_input(INPUT_POST, 'status_sensor', FILTER_SANITIZE_SPECIAL_CHARS);
$descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_SPECIAL_CHARS);

// Validação dos campos obrigatórios
if (empty($codigo) || empty($tipo) || empty($pinoEsp32) || empty($status)) {
    $_SESSION['mensagem_erro'] = "Preencha todos os campos obrigatórios para salvar o sensor.";
    header('Location: sensor-form.php' . ($id ? "?id={$id}" : ""));
    exit();
}

/*
 * Integração com o Banco de Dados (MySQL)
 * 
 * try {
 *     $pdo = new PDO("mysql:host=localhost;dbname=ja_ismaga;charset=utf8mb4", "root", "");
 *     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 * 
 *     if (!empty($id)) {
 *         // Atualiza registro existente
 *         $sql = $pdo->prepare("UPDATE sensores SET 
 *             codigo = :codigo, 
 *             tipo = :tipo, 
 *             trem_id = :trem_id, 
 *             rota_id = :rota_id, 
 *             pino_esp32 = :pino_esp32, 
 *             status = :status, 
 *             descricao = :descricao 
 *             WHERE id = :id");
 *         $sql->bindValue(':id', $id, PDO::PARAM_INT);
 *     } else {
 *         // Cadastra novo sensor
 *         $sql = $pdo->prepare("INSERT INTO sensores 
 *             (codigo, tipo, trem_id, rota_id, pino_esp32, status, descricao) 
 *             VALUES (:codigo, :tipo, :trem_id, :rota_id, :pino_esp32, :status, :descricao)");
 *     }
 * 
 *     $sql->bindValue(':codigo', $codigo);
 *     $sql->bindValue(':tipo', $tipo);
 *     $sql->bindValue(':trem_id', $tremId ? $tremId : null, PDO::PARAM_NULL);
 *     $sql->bindValue(':rota_id', $rotaId ? $rotaId : null, PDO::PARAM_NULL);
 *     $sql->bindValue(':pino_esp32', $pinoEsp32);
 *     $sql->bindValue(':status', $status);
 *     $sql->bindValue(':descricao', $descricao);
 *     $sql->execute();
 * 
 * } catch (PDOException $e) {
 *     $_SESSION['mensagem_erro'] = "Erro ao salvar o sensor no banco de dados.";
 *     header('Location: sensores.php');
 *     exit();
 * }
 */

// Feedback temporário para testes na interface
if (!empty($id)) {
    $_SESSION['mensagem_sucesso'] = "Sensor #{$id} atualizado com sucesso!";
} else {
    $_SESSION['mensagem_sucesso'] = "Novo sensor IoT cadastrado com sucesso!";
}

header('Location: sensores.php');
exit();