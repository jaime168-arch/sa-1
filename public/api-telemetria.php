<?php
header("Content-Type: application/json");
require_once __DIR__ . '/../database/conexao.php'; 


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);

    if (isset($dados['trem_id'], $dados['velocidade'], $dados['status_sensor'])) {
        try {
        
            $stmt = $pdo->prepare("INSERT INTO sensores (trem_id, velocidade, status_sensor, data_leitura) VALUES (:trem_id, :velocidade, :status_sensor, NOW())");
            $stmt->execute([
                ':trem_id' => $dados['trem_id'],
                ':velocidade' => $dados['velocidade'],
                ':status_sensor' => $dados['status_sensor']
            ]);

            echo json_encode(["status" => "sucesso", "mensagem" => "Dados salvos com sucesso"]);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(["status" => "erro", "mensagem" => $e->getMessage()]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["status" => "erro", "mensagem" => "Dados incompletos"]);
    }
} else {
    http_response_code(405);
    echo json_encode(["status" => "erro", "mensagem" => "Metodo nao permitido"]);
}
