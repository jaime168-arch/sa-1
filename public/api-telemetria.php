<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");

require_once __DIR__ . '/../config/conexao.php';
$metodo = $_SERVER['REQUEST_METHOD'];

if ($metodo === 'POST') {
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);

    $codigo_sensor = $dados['codigo_sensor'] ?? $_POST['codigo_sensor'] ?? null;
    $temperatura   = $dados['temperatura'] ?? $_POST['temperatura'] ?? null;
    $umidade       = $dados['umidade'] ?? $_POST['umidade'] ?? null;
    $velocidade    = $dados['velocidade'] ?? $_POST['velocidade'] ?? null;

    if (!$codigo_sensor) {
        http_response_code(400);
        echo json_encode([
            "status" => "erro",
            "mensagem" => "O campo codigo_sensor é obrigatório."
        ]);
        exit;
    }
    $sqlSensor = "SELECT id, trem_id FROM sensores WHERE codigo_sensor = ? LIMIT 1";
    $stmtSensor = $conn->prepare($sqlSensor);

    if ($stmtSensor) {
        $stmtSensor->bind_param("s", $codigo_sensor);
        $stmtSensor->execute();
        $resSensor = $stmtSensor->get_result();
        $sensorObj = $resSensor->fetch_assoc();

        if ($sensorObj) {
            $sensor_id = $sensorObj['id'];
            $trem_id   = $sensorObj['trem_id'];
            $sqlInsert = "INSERT INTO leituras_telemetria (sensor_id, trem_id, temperatura, umidade, velocidade) VALUES (?, ?, ?, ?, ?)";
            $stmtInsert = $conn->prepare($sqlInsert);

            if ($stmtInsert) {
                // "iiddd" -> integer, integer, double, double, double
                $stmtInsert->bind_param("iiddd", $sensor_id, $trem_id, $temperatura, $umidade, $velocidade);

                if ($stmtInsert->execute()) {
                    // Atualiza o status do sensor para ativo após leitura bem-sucedida
                    $sqlUpdate = "UPDATE sensores SET status_leitura = 'Ativo' WHERE id = ?";
                    $stmtUpd = $conn->prepare($sqlUpdate);
                    if ($stmtUpd) {
                        $stmtUpd->bind_param("i", $sensor_id);
                        $stmtUpd->execute();
                    }

                    http_response_code(201);
                    echo json_encode([
                        "status" => "sucesso",
                        "mensagem" => "Dados de telemetria gravados com sucesso!",
                        "leitura_id" => $stmtInsert->insert_id
                    ]);
                    exit;
                }
            }
        } else {
            http_response_code(444);
            echo json_encode([
                "status" => "erro",
                "mensagem" => "Sensor com o código informado não está cadastrado no sistema."
            ]);
            exit;
        }
    }

    http_response_code(500);
    echo json_encode([
        "status" => "erro",
        "mensagem" => "Erro de execução MySQLi: " . $conn->error
    ]);
    exit;

} elseif ($metodo === 'GET') {

    $sql = "SELECT l.*, s.codigo_sensor, t.nome AS nome_trem 
            FROM leituras_telemetria l
            LEFT JOIN sensores s ON l.sensor_id = s.id
            LEFT JOIN trens t ON l.trem_id = t.id
            ORDER BY l.id DESC LIMIT 20";

    $resultado = $conn->query($sql);

    if ($resultado) {
        $leituras = $resultado->fetch_all(MYSQLI_ASSOC);
        echo json_encode([
            "status" => "sucesso",
            "total"  => count($leituras),
            "dados"  => $leituras
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            "status" => "erro",
            "mensagem" => "Erro ao consultar telemetria: " . $conn->error
        ]);
    }
    exit;
}